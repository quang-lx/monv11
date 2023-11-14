<?php

namespace Modules\Admin\Repositories\Eloquent;

use Illuminate\Http\Request;
use Modules\Admin\Repositories\ConfigDisplayRepository;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;

class EloquentConfigDisplayRepository extends BaseRepository implements ConfigDisplayRepository
{
    public function serverPagingFor(Request $request, $relations = null)
    {
        $query = $this->newQueryBuilder();
        if ($relations) {
            $query = $query->with($relations);
        }

        if ($request->get('col_name') !== null) {
            $col_name = $request->get('col_name');
            $query->where('col_name', $col_name);
        }
        if ($request->get('table_name') !== null) {
            $table_name = $request->get('table_name');
            $query->where('table_name', $table_name);
        }

        $query->orderBy('position', 'desc');
        return $query->paginate($request->get('per_page', 10));
    }
}
