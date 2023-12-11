<?php
namespace Modules\Mon\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Collection;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;
use Modules\Mon\Repositories\PermissionRepository as PermissionRepositoryInterface;
use Illuminate\Http\Request;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface {
    public function serverPagingFor(Request $request, $relations = null)
    {
        $query = $this->newQueryBuilder();
        if ($relations) {
            $query = $query->with($relations);
        }
        $query->where('is_show', 1);

        if ($request->get('search') !== null) {
            $keyword = $request->get('search');
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'ilike', "%{$keyword}%")
                    ->orWhere('guard_name', 'ilike', "%{$keyword}%")
                    ->orWhere('id', 'ilike', "%{$keyword}%");
            });
        }

        if ($request->get('guard_name') !== null) {
            $query->where('guard_name', '=', $request->get('guard_name'));
        }
        if ($request->get('role_id') !== null) {
            $in_role =$request->get('in_role') ;
            if ( $in_role !== null) {
                if ($in_role) {
                    $query->whereHas('roles', function ($query) use ($request) {
                        $query->where('id', '=', $request->get('role_id'));
                    });
                } else {
                    $query->whereDoesntHave('roles', function ($query) use ($request){
                        $query->where('id', '=', $request->get('role_id'));
                    });
                }
            }else {
                $query->whereHas('roles', function ($query) use ($request) {
                    $query->where('id', '=', $request->get('role_id'));
                });
            }

        }

        if ($request->get('name') !== null) {
            $query->where('name', '=', $request->get('name'));
        }
        $query->select('permissions.*');

        return $query->paginate($request->get('per_page', 10));
    }
	public function serverPagingForGroup(Request $request, $relations = null)
	{
		$permissions = $this->getAllPermission($request, $relations);
		$groups =[];
		foreach ($permissions as $permission) {
			$groups[$permission->group][] = $permission;
		}
		return $groups;
	}
    public function serverPagingForGroupArray(Request $request, $relations = null)
    {
        $groups = $this->serverPagingForGroup($request,$relations );
         $groups_arr = [];
         /**
          * @var  $group_name
          * @var  $permission Collection
          */
        foreach ($groups as $group => $permission) {
            $groups_arr[] = [
                'group_name' => isset($permission[0])? $permission[0]->group_name: $group,
                'permissions'=> $permission
            ];
        }
        return $groups_arr;
    }

    /**
     * @param Request $request
     * @param $relations
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
	public function getAllPermission(Request $request, $relations) {
		$query = $this->newQueryBuilder();
		if ($relations) {
			$query = $query->with($relations);
		}
        $query->where('is_show', 1);

		if ($request->get('search') !== null) {
			$keyword = $request->get('search');
			$query->where(function ($q) use ($keyword) {
				$q->where('name', 'ilike', "%{$keyword}%")
					->orWhere('guard_name', 'ilike', "%{$keyword}%")
					->orWhere('id', 'ilike', "%{$keyword}%");
			});
		}

		if ($request->get('guard_name') !== null) {
			$query->where('guard_name', '=', $request->get('guard_name'));
		}
		if ($request->get('role_id') !== null) {
			$in_role =$request->get('in_role') ;
			if ( $in_role !== null) {
				if ($in_role) {
					$query->whereHas('roles', function ($query) use ($request) {
						$query->where('id', '=', $request->get('role_id'));
					});
				} else {
					$query->whereDoesntHave('roles', function ($query) use ($request){
						$query->where('id', '=', $request->get('role_id'));
					});
				}
			}else {
				$query->whereHas('roles', function ($query) use ($request) {
					$query->where('id', '=', $request->get('role_id'));
				});
			}

		}

		if ($request->get('name') !== null) {
			$query->where('name', '=', $request->get('name'));
		}
		$query->select('permissions.*')->orderBy('group')->orderBy('order_');

		return $query->get();
	}
}
