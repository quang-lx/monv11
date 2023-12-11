<?php

namespace Modules\Admin\Repositories\Eloquent;

use Modules\Admin\Repositories\DiseaseRepository;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;
use Illuminate\Http\Request;

class EloquentDiseaseRepository extends BaseRepository implements DiseaseRepository
{
    public function serverPagingFor(Request $request, $relations = null)
    {
        $query = $this->queryGetDisease($request, $relations = null);
        return $query->paginate($request->get('per_page', 10));
    }

    public function queryGetDisease($request, $relations = null)
    {
        $query = $this->newQueryBuilder();
        if ($relations) {
            $query = $query->with($relations);
        }

        if ($request->get('search') !== null) {
            $keyword = $request->get('search');
            $query->where(function ($q) use ($keyword) {
                $q->orWhere('name', 'ilike', "%{$keyword}%")
                    ->orWhere('code', 'ilike', "%{$keyword}%");
            });
        }

        $query->orderBy('updated_at', 'desc');
        return $query;
    }
}
