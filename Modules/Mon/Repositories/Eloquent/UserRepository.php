<?php

namespace Modules\Mon\Repositories\Eloquent;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Repositories\Eloquent\EloquentDepartmentRepository;
use Modules\Mon\Entities\Department;
use Modules\Mon\Repositories\UserRepository as UserInterface;
use Modules\Mon\Events\UserWasCreated;
use Modules\Mon\Events\UserWasDeleting;
use Modules\Mon\Events\UserWasUpdated;
use Modules\Mon\Entities\User;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Guard;

class UserRepository extends BaseRepository implements UserInterface
{

    public function create($data)
    {
        $data['created_by'] = Auth::user()->id;
        $user = $this->model->create($data);
        event(new UserWasCreated($user, $data));
        return $user;
    }

    public function update($model, $data)
    {
        $model->update($data);
        event(new UserWasUpdated($model, $data));
        return $model;
    }

    public function destroy($model)
    {
        $model->username = sprintf('deleted_%d_%s', date('YmdHis'), $model->username);
        $model->email = sprintf('deleted_%d_%s', date('YmdHis'), $model->email);
        $model->save();
        event(new UserWasDeleting($model));
        return $model->delete();
    }


    public function changePassword($model, $data)
    {
        $model->password = Hash::make($data['password_new']);
        $model->save();
        return $model;
    }

    public function resetPassword($model, $data)
    {
        $data = [];
        $data['password'] = env('DEFAULT_PASSWORD', '123456aA@');
        $data['password'] = Hash::make($data['password']);
        $data['need_change_password'] = User::NEED_CHANGE_PASSWORD;
        $model->update($data);
        return $model;
    }

    /**
     * Create a user and assign roles to it
     * @param  array $data
     * @param  array $roles
     * @return User
     */
    public function createWithRoles($data, $roles)
    {
        $data['created_by'] = Auth::user()->id;
        $user = null;
        DB::transaction(function () use (&$user, $data, $roles) {
            $this->checkForNewPassword($data);

            $user = $this->model->create((array) $data);
            event(new UserWasCreated($user, $data));
            if (!empty($roles)) {
                Config::set('auth.defaults.guard', 'web');
                $user->assignRole($roles);
            }
        });



        return $user;
    }
    /**
     * @param $model User
     * @param $data
     * @param $roles
     * @internal param $user
     * @return mixed
     */
    public function updateAndSyncRoles($model, $data, $roles)
    {
        DB::transaction(function () use (&$model, $data, $roles) {
            unset($data['password']);
            $model->update($data);

            event(new UserWasUpdated($model, $data));

            if (!empty($roles)) {
                Config::set('auth.defaults.guard', 'web');
                $model->syncRoles($roles);
            }
        });

        return $model;
    }
    /**
     * Check if there is a new password given
     * If not, unset the password field
     * @param array $data
     */
    private function checkForNewPassword(array &$data)
    {
        if (array_key_exists('password', $data) === false) {
            return;
        }

        if ($data['password'] === '' || $data['password'] === null) {
            unset($data['password']);

            return;
        }

        $data['password'] = Hash::make($data['password']);
    }
    public function generateTokenFor(User $user)
    {
        return app(\Modules\Mon\Repositories\UserTokenRepository::class)->create([
            'user_id' => $user->id,
            'access_token' => Uuid::uuid4()->toString()
        ]);
    }

    /**
     *
     * @param Request $request
     * @param null $relations
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function serverPagingFor(Request $request, $relations = null)
    {
        $query = $this->queryGetUsers($request, $relations);
        return $query->paginate($request->get('per_page', 10));
    }

    public function queryGetUsers($request, $relations = null)
    {
        $query = $this->newQueryBuilder();
        if ($relations) {
            $query = $query->with($relations);
        }
        if ($request->get('search') !== null) {
            $keyword = $request->get('search');
            $query->where(function ($q) use ($keyword) {

                $q->orWhere('name', 'ilike', "%{$keyword}%")
                    ->orWhere('email', 'ilike', "%{$keyword}%")
                    ->orWhere('phone', 'ilike', "%{$keyword}%")
                    ->orWhere('id', 'ilike', "%{$keyword}%")
                    ->orWhere('username', 'ilike', "%{$keyword}%")
                    ->orWhere('identification', 'ilike', "%{$keyword}%");
            });
        }
        $exclude_ids = $request->get('exclude_ids', null);
        if ($exclude_ids && is_array($exclude_ids) && count($exclude_ids) > 0) {
            $query->whereNotIn('id', $exclude_ids);
        }

        // advance filter
        $status = $request->get('status');
        if ($status == User::STATUS_ACTIVE) {

            $query->where('expired_at', '>=', Carbon::now());
        } elseif ($status == User::STATUS_INACTIVE) {

            $query->where('expired_at', '<', Carbon::now());
        }

        $department_id = $request->get('department_id');
        if ($department_id !== null) {
            $department_repo = new EloquentDepartmentRepository(new Department());
            $list_parent = $department_repo->getChild($department_id);
            $query->whereIn('department_id', $list_parent);
        }

        $sex = $request->get('sex');
        if ($sex !== null) {

            $query->where('sex', $sex);
        }
        $created_by = $request->get('created_by');
        if ($created_by !== null) {

            $query->where('created_by', $created_by);
        }
        $time_range = $request->get('time_range');
        if ($time_range !== null && count($time_range) > 0) {

            $query->whereBetween('created_at', $time_range);
        }

        if ($request->get('name') !== null) {
            $name = $request->get('name');
            $query->where('name', 'ilike', "%{$name}%");
        }

        if ($request->get('email') !== null) {
            $email = $request->get('email');
            $query->where('email', 'ilike', "%{$email}");
        }

        if ($request->get('role_name') !== null) {
            $roleName = $request->get('role_name');
            $query->whereHas('roles', function ($q) use ($roleName) {
                $q->where('name', '=', $roleName);
            });
        }

        if ($request->get('role_id') !== null) {
            $roleId = $request->get('role_id');
            $query->whereHas('roles', function ($q) use ($roleId) {
                $q->where('id', '=', $roleId);
            });
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
        return $query;
    }

}
