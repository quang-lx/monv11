<?php

namespace Modules\Admin\Repositories\Eloquent;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Admin\Repositories\PatientRepository;
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
        foreach ($data['list_service'] as $key => $value) {
            $patient_has_service = new PatientHasService;
            $patient_has_service->patient_id = $model->id;
            $patient_has_service->service_id = $value['service_id'];
            $patient_has_service->created_by = Auth::user()->id;
            $patient_has_service->save();
        }
    }

    public function update($patient, $data)
    {
        $list_id = [];
        $patient->update($data);
        foreach ($data['list_service'] as $key => $value) {
            $patient_has_service = PatientHasService::where('patient_id', $patient->id)->where('service_id', $value['service_id'])->first();
            if (!$patient_has_service) {
                $patient_has_service = new PatientHasService;
            }
            $patient_has_service->patient_id = $patient->id;
            $patient_has_service->service_id = $value['service_id'];
            $patient_has_service->created_by = Auth::user()->id;
            $patient_has_service->save();
            $list_id[] = $value['id'] ?? null;
        }

        PatientHasService::whereNotIn('id', $list_id)->delete();
    }

    public function getPatientHasService(Request $request, $relations = null)
    {
        $query = PatientHasService::query();
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

        if ($request->get('patient_id') !== null) {
            $query->where('patient_id', $request->get('patient_id'));
        }

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
        if ($time_range !== null) {

            $query->whereBetween('birthday', $time_range);
        }

        if ($request->get('search') !== null) {
            $keyword = $request->get('search');
            $query->where(function ($q) use ($keyword) {
                $q->orWhere('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('code', 'LIKE', "%{$keyword}%")
                    ->orWhere('phone', 'LIKE', "%{$keyword}%")
                    ->orWhere('address', 'LIKE', "%{$keyword}%")
                    ->orWhere('papers', 'LIKE', "%{$keyword}%")
                    ->orWhere('job', 'LIKE', "%{$keyword}%");
            });
        }

        $query->orderBy('updated_at', 'desc');
        return $query;
    }
}
