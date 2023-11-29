<?php

namespace Modules\Admin\Repositories\Eloquent;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Admin\Repositories\PatientRepository;
use Modules\Mon\Entities\PatientHasService;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;
use Illuminate\Http\Request;

class EloquentPatientRepository extends BaseRepository implements PatientRepository
{

    public function create($data)
    {
        $data['created_by'] = Auth::user()->id;
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
}
