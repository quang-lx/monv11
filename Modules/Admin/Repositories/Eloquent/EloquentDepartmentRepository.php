<?php

namespace Modules\Admin\Repositories\Eloquent;

use Modules\Admin\Repositories\DepartmentRepository;
use Modules\Mon\Entities\Department;
use Modules\Mon\Entities\User;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;

class EloquentDepartmentRepository extends BaseRepository implements DepartmentRepository
{
    public function destroy($model)
    {
        $id = $model->id;
        Department::query()->where('parent_id', $id)->update(['not_assign' => 1]);
        return $model->delete();
    }
    public function getAllTree($parent_id = null, $request) {
        $data = [];
        $query = $this->newQueryBuilder();
        $query->where('not_assign', 0);
        $query->where('name', 'ilike',  "%{$request->search}%");
        if ($parent_id) {
            $query->where('parent_id', $parent_id);
        } else {
            $query->whereNull('parent_id');
        }
        $departments = $query->get();

        foreach ($departments as $department) {

            $children = $this->getAllTree($department->id, $request);
            $count_user = User::query()->where('department_id', $department->id)->count();
            foreach ($children as $item) {
                $count_user += $item['count_user'];
            }
            $row = [
                'id' => $department->id,
                'label' => $department->name,
                'count_user' => $count_user?? 0,
                'children' => $children
            ];
            $data[] = $row;
        }
        return $data;
    }
    public function getNotAssignTree($parent_id = null, $request) {
        $data = [];
        $query = $this->newQueryBuilder();
        $query->where('not_assign', 1);
        $query->where('name', 'ilike',  "%{$request->search}%");
        if ($parent_id) {
            $query->where('parent_id', $parent_id);
        } else {
            $query->whereNull('parent_id');
        }
        $departments = $query->get();

        foreach ($departments as $department) {

            $children = $this->getAllTree($department->id, $request);
            $count_user = User::query()->where('department_id', $department->id)->count();
            foreach ($children as $item) {
                $count_user += $item['count_user'];
            }
            $row = [
                'id' => $department->id,
                'label' => $department->name,
                'count_user' => $count_user?? 0,
                'children' => $children
            ];
            $data[] = $row;
        }
        return $data;
    }
    public function getAllHierarchy($parent_id = null) {
        $data = [];
        $query = $this->newQueryBuilder();
        if ($parent_id) {
            $query->where('parent_id', $parent_id);
        } else {
            $query->whereNull('parent_id');
        }
        $departments = $query->get();
        foreach ($departments as $department) {
            $name = $department->name;
            if ($department->parent_id) {
                $name = '---'.$name;
            }
            $row = [
                'id' => $department->id,
                'name' => $name

            ];
            $data[] = $row;
            $data = array_merge($data, $this->getAllHierarchy($department->id));

        }
        return $data;
    }
}
