<?php

namespace Modules\Admin\Repositories\Eloquent;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Repositories\ExaminationHealthRepository;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;

class EloquentExaminationHealthRepository extends BaseRepository implements ExaminationHealthRepository
{
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
            $query->whereBetween('create_date', $filter_date_range);
        }

        if ($request->get('examination_id') !== null) {
            $examination_id = $request->get('examination_id');
            $query->where('examination_id', $examination_id);
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
