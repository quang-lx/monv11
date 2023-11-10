<?php

namespace Modules\Admin\Repositories\Eloquent;

use Modules\Admin\Repositories\DepartmentRepository;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;

class EloquentDepartmentRepository extends BaseRepository implements DepartmentRepository
{
    public function getAllTree($parent_id = null) {
        $data = [];
        $query = $this->newQueryBuilder();
        if ($parent_id) {
            $query->where('parent_id', $parent_id);
        } else {
            $query->whereNull('parent_id');
        }
        $departments = $query->get();
        foreach ($departments as $department) {
            $row = [
                'id' => $department->id,
                'label' => $department->name,
                'children' => $this->getAllTree($department->id)
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
