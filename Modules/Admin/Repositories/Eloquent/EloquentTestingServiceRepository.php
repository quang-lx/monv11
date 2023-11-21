<?php

namespace Modules\Admin\Repositories\Eloquent;

use Illuminate\Http\Request;
use Modules\Admin\Repositories\TestingServiceRepository;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;

class EloquentTestingServiceRepository extends BaseRepository implements TestingServiceRepository
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
                $q->where('code', 'LIKE', "%{$keyword}%");
                $q->where('code_lis', 'LIKE', "%{$keyword}%");
                $q->where('name', 'LIKE', "%{$keyword}%");
                $q->where('type', 'LIKE', "%{$keyword}%");

            });
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
