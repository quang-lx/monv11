<?php

namespace Modules\Admin\Repositories\Eloquent;

use Illuminate\Http\Request;
use Modules\Admin\Repositories\PostRepository;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;

class EloquentPostRepository extends BaseRepository implements PostRepository
{

    public function serverPagingFor(Request $request, $relations = null)
    {
        $query = $this->newQueryBuilder();

        if ($request->get('search') !== null) {
            $keyword = $request->get('search');
            $query->where(function ($q) use ($keyword) {
                $q->orWhere('name', 'ilike', "%{$keyword}%");
            });
        }
        return $query->paginate($request->get('per_page', 10));
    }
}
