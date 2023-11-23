<?php

namespace Modules\Admin\Repositories\Eloquent;

use Illuminate\Http\Request;
use Modules\Admin\Repositories\TestingServiceRepository;
use Modules\Mon\Entities\ServiceIndex;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;

class EloquentTestingServiceRepository extends BaseRepository implements TestingServiceRepository
{
    public function create($data)
    {
        $list_service_index= $data['list_service_index']?? [];

        unset($data['list_service_index']);

        $model = $this->model->create($data);
        if (count($list_service_index)) {
            $this->syncServiceIndex($model,$list_service_index);
        }
        return $model;
    }

    public function update($model, $data)
    {
        $list_service_index= $data['list_service_index']?? [];

        unset($data['list_service_index']);
        $model->update($data);
        if (count($list_service_index)) {
            $this->syncServiceIndex($model,$list_service_index);
        }

        return $model;
    }
    public function syncServiceIndex($model,$list_service_index) {
        $list_service_id = [];
        foreach ($list_service_index as $service_index_data) {
            $id = $service_index_data['id']?? null;
            $service_index_model = null;
            if ($id) {
                /** @var ServiceIndex $service_index_model */
                $service_index_model = ServiceIndex::query()->where('id',$id)
                    ->where('service_id', $model->id)
                    ->first();

            }
            if ($service_index_model) {
                $service_index_model->fill($service_index_data);
            } else {
                $service_index_data['service_id'] = $model->id;
                $service_index_model = ServiceIndex::create($service_index_data);
            }
            if($service_index_model) {
                $list_service_id[]= $service_index_model->id;
            }
        }

        // delete not in
        ServiceIndex::query()->where('service_id', $model->id)
            ->whereNotIn('id', $list_service_id)->delete();
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
                $q->orWhere('code', 'LIKE', "%{$keyword}%");
                $q->orWhere('code_lis', 'LIKE', "%{$keyword}%");
                $q->orWhere('name', 'LIKE', "%{$keyword}%");
                $q->orWhere('type', 'LIKE', "%{$keyword}%");

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
