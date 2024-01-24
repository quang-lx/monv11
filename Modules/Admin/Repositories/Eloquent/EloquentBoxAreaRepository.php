<?php

namespace Modules\Admin\Repositories\Eloquent;

use Modules\Admin\Repositories\BoxAreaRepository;
use Modules\Mon\Entities\Box;
use Modules\Mon\Entities\BoxArea;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;

class EloquentBoxAreaRepository extends BaseRepository implements BoxAreaRepository
{
    public function destroy($model)
    {
        $id = $model->id;
        BoxArea::query()->where('parent_id', $id)->update(['not_assign' => 1]);
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
        $areas = $query->get();

        foreach ($areas as $area) {

            $children = $this->getAllTree($area->id, $request);
            $count_box = Box::query()->where('area_id', $area->id)->count();
            foreach ($children as $item) {
                $count_box += $item['count_box'];
            }
            $row = [
                'id' => $area->id,
                'label' => $area->name,
                'count_box' => $count_box?? 0,
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
        $areas = $query->get();

        foreach ($areas as $area) {

            $children = $this->getAllTree($areas->id, $request);
            $count_box = Box::query()->where('area_id', $areas->id)->count();
            foreach ($children as $item) {
                $count_box += $item['count_box'];
            }
            $row = [
                'id' => $areas->id,
                'label' => $areas->name,
                'count_box' => $count_box?? 0,
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
        $areas = $query->get();
        foreach ($areas as $area) {
            $name = $area->name;
            if ($area->parent_id) {
                $name = '---'.$name;
            }
            $row = [
                'id' => $area->id,
                'name' => $name

            ];
            $data[] = $row;
            $data = array_merge($data, $this->getAllHierarchy($area->id));

        }
        return $data;
    }
    public function getChild($parent_id = null) {
        $data = [];
        $data[] = $parent_id;
        $query = $this->newQueryBuilder();
        if ($parent_id) {
            $query->where('parent_id', $parent_id);
        } else {
            $query->whereNull('parent_id');
        }
        $areas = $query->get();
        foreach ($areas as $area) {


            $data = array_merge($data, $this->getChild($area->id));

        }
        return $data;
    }
}
