<?php

namespace Modules\Admin\Repositories\Eloquent;

use Illuminate\Http\Request;
use Modules\Admin\Repositories\ExaminationIndexRepository;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;

class EloquentExaminationIndexRepository extends BaseRepository implements ExaminationIndexRepository
{
    public function serverPagingFor(Request $request, $relations = null)
    {
        $query = $this->newQueryBuilder();
        if ($relations) {
            $query = $query->with($relations);
        }

        if ($request->get('examination_service_id') !== null) {
            $examination_service_id = $request->get('examination_service_id');
            $query->where('examination_service_id', $examination_service_id);
        }



        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

            $query->orderBy($request->get('order_by'), $order);
        } else {
            $query->orderBy('updated_at', 'desc');
        }


        return $query->paginate($request->get('per_page', 1000));
    }
}
