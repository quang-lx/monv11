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

class EloquentPatientRepository extends BaseRepository implements PatientRepository
{

    public function create($data)
    {

        $data['created_by'] = Auth::user()->id;
        $data['data_sources'] = Patient::Local;
        $data['status'] = Patient::STATUS_RECEIVE;
        $model = $this->model->create($data);
        $this->initExamination($model);


        return $model;
    }
    public function initExamination($model) {
        $examination = new PatientExamination();
        $examination->patient_id = $model->id;
        $examination->started_at = Carbon::now();
        $examination->status = PatientExamination::STATUS_INIT;
        $examination->save();
    }



    public function reExamination($patient, $data)
    {
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
                $query->where('testing_service.name', 'LIKE', "%{$keyword}%")
                    ->orWhere('testing_service.code', 'LIKE', "%{$keyword}%");
            });
        }

        $query->where('patient_id', $patient->id);
        $query->where('examination_id', $patient->current_examination->id);


        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

            $query->orderBy($request->get('order_by'), $order);
        } else {
            $query->orderBy('updated_at', 'desc');
        }

        return $query->paginate($request->get('per_page', 10));
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
            $query->where('status', $status);
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

            $query->whereBetween('birthday', $time_range);
        }

        if ($request->get('search') !== null) {
            $keyword = $request->get('search');
            $query->where(function ($q) use ($keyword) {
                $q->orWhere('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('phone', 'LIKE', "%{$keyword}%")
                    ->orWhere('address', 'LIKE', "%{$keyword}%")
                    ->orWhere('papers', 'LIKE', "%{$keyword}%")
                    ->orWhere('job', 'LIKE', "%{$keyword}%");
            });
        }

        $query->orderBy('updated_at', 'desc');
        return $query;
    }

    function patientSamePhoneNumber($phone)
    {
        return Patient::where('phone', $phone)->get();
    }

    function changeStatus($data)
    {
        $patient = Patient::find($data['id']);
        $status = $patient->status;
        if ($status == Patient::STATUS_DONE) {
            $patient->status = $data['status'];
            $patient->save();
            return response()->json([
                'errors' => false,
                'message' => trans('backend::patient.message.update success'),
            ]);
        } else {
            return response()->json([
                'errors' => true,
                'message' => trans('backend::patient.message.re-examination fail'),
            ]);
        }
    }

    public function addService(Patient $patient, Request $request) {
        $current_examination = $patient->current_examination;
        if ($current_examination) {
            $list_service= $request->get('list_service', []);
            foreach ($list_service as $service_id) {
                if(ExaminationService::query()->where([
                    'patient_id' =>  $patient->id,
                    'examination_id' =>  $current_examination->id,
                    'service_id' =>  $service_id
                ])->count() == 0) {
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
}
