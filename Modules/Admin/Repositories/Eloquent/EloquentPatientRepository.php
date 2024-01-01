<?php

namespace Modules\Admin\Repositories\Eloquent;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Admin\Repositories\PatientRepository;
use Modules\Mon\Entities\ExaminationService;
use Modules\Mon\Entities\PatientExamination;
use Modules\Mon\Entities\PatientHasService;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;
use Illuminate\Http\Request;
use Modules\Mon\Entities\Patient;
use Symfony\Component\ErrorHandler\Error\ClassNotFoundError;

class EloquentPatientRepository extends BaseRepository implements PatientRepository
{

    public function create($data)
    {
        unset($data['current_examination']);
        $data['created_by'] = Auth::user()->id;
        $data['data_sources'] = Patient::Local;
        $model = $this->model->create($data);
        $this->initExamination($model);


        return $model;
    }

    public function update($model, $data)
    {
        $diagnose = $data['diagnose'] ?? '';
        unset($data['diagnose']);
        $model->update($data);
        $current_examination = $model->current_examination;
        if ($current_examination) {
            $current_examination->diagnose = $diagnose;
            $current_examination->save();
        }
        return $model;
    }

    public function initExamination($model)
    {
        $examination = new PatientExamination();
        $examination->patient_id = $model->id;
        $examination->created_by = Auth::user()->id;
        $examination->status = PatientExamination::STATUS_INIT;
        $type = PatientExamination::query()->where('patient_id', $model->id)->count();
        $examination->type = $type == 0 ? PatientExamination::TYPE_NEW: PatientExamination::TYPE_AGAIN;
        $examination->save();
    }


    /**
     * @param $patient Patient
     * @param $data
     * @return mixed
     */
    public function reExamination($patient, $data)
    {
        if ($patient->hasExaminationNotDone()) {
            throw new \Exception("Bệnh nhân vẫn chưa hoàn thành khám. Không thể tái khám");
        }
        $this->initExamination($patient);
        return $patient;
    }

    public function getCurrentExaminationService(Patient $patient, Request $request, $relations = null)
    {
        $query = ExaminationService::query();
        if ($relations) {
            $query = $query->with($relations);
        }
        if ($request->get('search') !== null) {
            $keyword = $request->get('search');

            $query->whereHas('testingService', function ($query) use ($keyword) {
                $query->where('testing_service.name', 'ilike', "%{$keyword}%")
                    ->orWhere('testing_service.code', 'ilike', "%{$keyword}%");
            });
        }
        if ($request->get('examination_id') !== null) {
            $examination_id = $request->get('examination_id');
            $query->where('examination_id', $examination_id);
        }

        if (!$request->get('examination_id')) {
            $query->where('examination_id', $patient->current_examination->id);
        }
        $query->where('patient_id', $patient->id);



        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

            $query->orderBy($request->get('order_by'), $order);
        } else {
            $query->orderBy('updated_at', 'desc');
        }

        return $query->paginate($request->get('per_page', 1000));
    }

    public function serverPagingFor(Request $request, $relations = null)
    {
        $query = $this->queryGetPatients($request, $relations = null);
        return $query->paginate($request->get('per_page', 10));
    }

    public function queryGetPatients($request, $relations = null)
    {
        $query = $this->newQueryBuilder();
        if ($relations) {
            $query = $query->with($relations);
        }

        $status = $request->get('status');
        if ($status !== null) {
            $query->whereHas('examinations', function ($query) use ($status) {
                $query->where('status', $status)->latest()
                ->limit(1);;
            });
        }

        $data_source = $request->get('data_source');
        if ($data_source !== null) {
            $query->where('data_source', $data_source);
        }

        $sex = $request->get('sex');
        if ($sex !== null) {
            $query->where('sex', $sex);
        }

        $time_range = $request->get('time_range');
        
        
        if ($time_range !== null && count($time_range) > 0) {
            $birthday_start_date = Carbon::parse($time_range[0])->startOfDay();
            $birthday_end_date = Carbon::parse($time_range[1])->endOfDay();
            $query->whereBetween('birthday', [$birthday_start_date, $birthday_end_date]);
        }

        $created_at = $request->get('created_at');
       
        if ($created_at !== null && count($created_at) > 0) {
            $created_at_start_date = Carbon::parse($created_at[0])->startOfDay();
            $created_at_end_date = Carbon::parse($created_at[1])->endOfDay();
            $query->whereBetween('created_at', [$created_at_start_date, $created_at_end_date]);
        }

        if ($request->get('search') !== null) {
            $keyword = $request->get('search');
            $query->where(function ($q) use ($keyword) {
                $q->orWhere('name', 'ilike', "%{$keyword}%")
                    ->orWhere('phone', 'ilike', "%{$keyword}%")
                    ->orWhere('address', 'ilike', "%{$keyword}%")
                    ->orWhere('papers', 'ilike', "%{$keyword}%")
                    ->orWhere('job', 'ilike', "%{$keyword}%");
            });
        }

        $query->orderBy('updated_at', 'desc');
        return $query;
    }

    function patientSamePhoneNumber($phone, $patient_id = null)
    {
        $query = Patient::query()->where('phone', $phone);
        if ($patient_id) {
            $query->where('id', '<>', $patient_id);
        }
        return $query->get();
    }



    public function addService(Patient $patient, Request $request)
    {
        $current_examination = $patient->current_examination;
        if ($current_examination) {
            $list_service = $request->get('list_service', []);
            foreach ($list_service as $service_id) {
                if (
                    ExaminationService::query()->where([
                        'patient_id' => $patient->id,
                        'examination_id' => $current_examination->id,
                        'service_id' => $service_id
                    ])->count() == 0
                ) {
                    $examination_service = new ExaminationService();
                    $examination_service->patient_id = $patient->id;
                    $examination_service->examination_id = $current_examination->id;
                    $examination_service->service_id = $service_id;
                    $examination_service->status = ExaminationService::STATUS_NEW;
                    $examination_service->created_by = Auth::user()->id;
                    $examination_service->save();

                }

            }

        }
    }
    public function deleteService(Patient $patient, Request $request)
    {
        $examination_service_id = $request->get('examination_service_id');
        /** @var ExaminationService $model */
        $model = ExaminationService::query()->where([
            'patient_id' => $patient->id,
            'id' => $examination_service_id
        ])->first();

        if (!$model) {
            throw new ClassNotFoundError("Dịch vụ không tồn tại");
        } elseif ($model->status != ExaminationService::STATUS_NEW) {
            throw new ClassNotFoundError("Không được xoá dịch vụ ở trạng thái " . $model->status_text);
        }
        $model->delete();
    }
    public function cancelService(Patient $patient, Request $request)
    {
        $examination_service_id = $request->get('examination_service_id');
        /** @var ExaminationService $model */
        $model = ExaminationService::query()->where([
            'patient_id' => $patient->id,
            'id' => $examination_service_id
        ])->first();

        if (!$model) {
            throw new ClassNotFoundError("Dịch vụ không tồn tại");
        } elseif ($model->status != ExaminationService::STATUS_PROCESSING) {
            throw new ClassNotFoundError("Không được xoá dịch vụ ở trạng thái " . $model->status_text);
        }
        $model->status = ExaminationService::STATUS_CANCEL;
        $model->save();
    }
}
