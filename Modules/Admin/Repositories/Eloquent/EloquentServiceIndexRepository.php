<?php

namespace Modules\Admin\Repositories\Eloquent;

use Illuminate\Http\Request;
use Modules\Admin\Repositories\ServiceIndexRepository;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;

class EloquentServiceIndexRepository extends BaseRepository implements ServiceIndexRepository
{
    public function serverPagingFor(Request $request, $relations = null)
    {
        $query = $this->newQueryBuilder();
        if ($relations) {
            $query = $query->with($relations);
        }
        if ($request->get('search') !== null) {
            $keyword = $request->get('search');
            $query->where(function ($q) use ($keyword) {
                $q->orWhere('code', 'LIKE', "%{$keyword}%");
                $q->orWhere('code_lis', 'LIKE', "%{$keyword}%");
                $q->orWhere('name', 'LIKE', "%{$keyword}%");
                $q->orWhere('type', 'LIKE', "%{$keyword}%");

            });
        }
        if ($request->get('service_id') !== null) {
            $service_id = $request->get('service_id');
            $query->where('service_id', $service_id);
        }

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

            $query->orderBy($request->get('order_by'), $order);
        } else {
            $query->orderBy('created_at', 'desc');
        }


        return $query->paginate($request->get('per_page', 10));
    }
}
