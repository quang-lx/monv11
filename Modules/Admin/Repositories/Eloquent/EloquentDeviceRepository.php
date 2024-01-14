<?php

namespace Modules\Admin\Repositories\Eloquent;

use Illuminate\Http\Request;
use Modules\Admin\Events\Category\DeviceWasUpdated;
use Modules\Admin\Events\DeviceWasCreated;
use Modules\Admin\Repositories\DeviceRepository;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;

class EloquentDeviceRepository extends BaseRepository implements DeviceRepository
{

    public function serverPagingFor(Request $request, $relations = null)
    {
        $query = $this->queryGetDevice($request, $relations = null);
        return $query->paginate($request->get('per_page', 10));
    }

    public function queryGetDevice($request, $relations = null)
    {
        $query = $this->newQueryBuilder();
        if ($relations) {
            $query = $query->with($relations);
        }

        if ($request->get('search') !== null) {
            $keyword = $request->get('search');
            $query->where(function ($q) use ($keyword) {
                $q->orWhere('name', 'ilike', "%{$keyword}%")
                    ->orWhere('code', 'ilike', "%{$keyword}%")
                    ->orWhere('type', 'ilike', "%{$keyword}%")
                    ->orWhere('box', 'ilike', "%{$keyword}%")
                    ->orWhere('serial_number', 'ilike', "%{$keyword}%")
                    ->orWhere('status', 'ilike', "%{$keyword}%")
                    ->orWhere('note', 'ilike', "%{$keyword}%");

            });
        }

        $query->orderBy('updated_at', 'desc');
        return $query;
    }

    public function create($data)
    {
        $model = $this->model->create($data);
        event(new DeviceWasCreated($model, $data));

        return $model;
    }

    public function update($model, $data)
    {
        $model = $model->update($data);
        event(new DeviceWasUpdated($model, $data));

        return $model;
    }

}
