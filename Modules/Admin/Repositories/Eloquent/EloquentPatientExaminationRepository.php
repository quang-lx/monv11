<?php

namespace Modules\Admin\Repositories\Eloquent;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Repositories\PatientExaminationRepository;
use Modules\Mon\Entities\PatientExamination;
use Modules\Mon\Repositories\Eloquent\BaseRepository;

class EloquentPatientExaminationRepository extends BaseRepository implements PatientExaminationRepository
{
    public function startExamination(PatientExamination $model, Request $request)
    {
        if ($model->status != PatientExamination::STATUS_INIT) {
            throw new \Exception("Trạng thái không cho phép thực hiện hành động này");
        }
        $model->status = PatientExamination::STATUS_PROCESSING;
        $model->started_at = Carbon::now();
        $model->save();
        return $model;
    }

    public function finishExamination(PatientExamination $model, Request $request)
    {
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
            $query->where(function ($query) use ($filter_date_range) {
                $query->whereBetween('started_at', $filter_date_range)
                    ->orWhereBetween('finished_at', $filter_date_range)
                    ->orWhere(function ($query) use ($filter_date_range) {
                        $query->where('started_at', '<', $filter_date_range[0])
                            ->where('finished_at', '<', $filter_date_range[1]);
                    });
            });

        }
        $status = $request->get('status');
        if ($status) {
            $query->where('status', $status);

        }
        $created_at = $request->get('created_at');
        if ($created_at && is_array($created_at) && count($created_at) == 2) {
            $query->whereBetween(DB::raw('DATE(created_at)'), $created_at);

        }
        $started_at = $request->get('started_at');
        if ($started_at && is_array($started_at) && count($started_at) == 2) {
            $query->whereBetween(DB::raw('DATE(started_at)'), $started_at);

        }

        $finished_at = $request->get('finished_at');
        if ($finished_at && is_array($finished_at) && count($finished_at) == 2) {
            $query->whereBetween(DB::raw('DATE(finished_at)'), $finished_at);

        }

        $birthday = $request->get('birthday');
        if ($birthday && is_array($birthday) && count($birthday) == 2) {
            $query->whereHas('patient', function ($query) use ($birthday) {
                $query->whereBetween(DB::raw('DATE(birthday)'), $birthday);

            });

        }

        $sex = $request->get('sex');
        if ($sex) {
            $query->whereHas('patient', function ($query) use ($sex) {
                $query->where('sex', $sex);

            });

        }

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

            $query->orderBy($request->get('order_by'), $order);
        } else {
            $query->orderByRaw("
             array_position(array['init','processing','done'], patient_examination.status)
           ");
        }


        return $query->paginate($request->get('per_page', 10));
    }
}
