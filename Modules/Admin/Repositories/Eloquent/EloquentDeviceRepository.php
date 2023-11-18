<?php

namespace Modules\Admin\Repositories\Eloquent;

use Illuminate\Http\Request;
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
                $q->orWhere('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('code', 'LIKE', "%{$keyword}%")
                    ->orWhere('type', 'LIKE', "%{$keyword}%")
                    ->orWhere('box', 'LIKE', "%{$keyword}%")
                    ->orWhere('serial_number', 'LIKE', "%{$keyword}%")
                    ->orWhere('status', 'LIKE', "%{$keyword}%")
                    ->orWhere('note', 'LIKE', "%{$keyword}%");

            });
        }

        $query->orderBy('updated_at', 'desc');
        return $query;
    }
}
