<?php

namespace Modules\Admin\Repositories\Eloquent;

use Illuminate\Http\Request;
use Modules\Admin\Events\Category\CategoryWasCreated;
use Modules\Admin\Events\Category\CategoryWasUpdated;
use Modules\Admin\Repositories\CategoryRepository;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;

class EloquentCategoryRepository extends BaseRepository implements CategoryRepository
{
    public function create($data)
    {
        $model = $this->model->create($data);
        event(new CategoryWasCreated($model, $data));
        return $model;
    }

    public function update($model, $data)
    {
        $model->update($data);
        event(new CategoryWasUpdated($model, $data));
        return $model;
    }
    public function serverPagingFor(Request $request, $relations = null)
    {
        $query = $this->newQueryBuilder();
        if ($relations) {
            $query = $query->with($relations);
        }
        if ($request->get('search') !== null) {
            $keyword = $request->get('search');
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'ilike', "%{$keyword}%");

            });
        }
        if ($request->get('status') !== null) {
            $status = $request->get('status');
            $query->where('status', $status);
        }

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

            $query->orderBy($request->get('order_by'), $order);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        if ($request->get('group_by') !== null) {
            $query->groupBy(explode(",", $request->get('group_by')));
        }
        return $query->paginate($request->get('per_page', 10));
    }
}
