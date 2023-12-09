<?php

namespace Modules\Admin\Repositories\Eloquent;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Admin\Repositories\PatientExaminationRepository;
use Modules\Mon\Entities\PatientExamination;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;

class EloquentPatientExaminationRepository extends BaseRepository implements PatientExaminationRepository
{
    public function startExamination(PatientExamination $model,Request $request) {
        if ($model->status != PatientExamination::STATUS_INIT) {
            throw new \Exception("Trạng thái không cho phép thực hiện hành động này");
        }
        $model->status = PatientExamination::STATUS_PROCESSING;
        $model->started_at = Carbon::now();
        $model->save();
        return $model;
    }
    public function finishExamination(PatientExamination $model,Request $request) {
        if ($model->status != PatientExamination::STATUS_PROCESSING) {
            throw new \Exception("Trạng thái không cho phép thực hiện hành động này");
        }
        $model->status = PatientExamination::STATUS_DONE;
        $model->finished_at = Carbon::now();
        $model->save();
        return $model;
    }
    public function serverPagingFor(Request $request, $relations = null)
    {
        $query = $this->newQueryBuilder();
        if ($relations) {
            $query = $query->with($relations);
        }

        if ($request->get('patient_id') !== null) {
            $patient_id = $request->get('patient_id');
            $query->where('patient_id', $patient_id);
        }

        $filter_date_range = $request->get('filter_date_range');

        if ($filter_date_range && is_array($filter_date_range) && count($filter_date_range) == 2) {
            $query->whereBetween('started_at', $filter_date_range)
                ->orWhereBetween('finished_at', $filter_date_range)
                ->orWhere(function ($query) use ($filter_date_range){
                    $query->where('started_at', '<', $filter_date_range[0])
                        ->where('finished_at', '<', $filter_date_range[1]);
            });
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
