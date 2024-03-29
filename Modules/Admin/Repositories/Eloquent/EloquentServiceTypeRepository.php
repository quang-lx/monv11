<?php

namespace Modules\Admin\Repositories\Eloquent;

use Illuminate\Http\Request;
use Modules\Admin\Repositories\ServiceTypeRepository;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;

class EloquentServiceTypeRepository extends BaseRepository implements ServiceTypeRepository
{
    public function serverPagingFor(Request $request, $relations = null)
    {
        $query = $this->queryGetData($request, $relations = null);
        return $query->paginate($request->get('per_page', 10));
    }

    public function queryGetData($request, $relations = null)
    {
        $query = $this->newQueryBuilder();
        if ($relations) {
            $query = $query->with($relations);
        }
        if ($request->get('search') !== null) {
            $keyword = $request->get('search');
            $query->where(function ($q) use ($keyword) {
                $q->orWhere('code', 'ilike', "%{$keyword}%");
                $q->orWhere('name', 'ilike', "%{$keyword}%");

            });
        }


        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

            $query->orderBy($request->get('order_by'), $order);
        } else {
            $query->orderBy('created_at', 'desc');
        }
        return $query;
    }
}
