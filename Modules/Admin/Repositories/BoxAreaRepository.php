<?php

namespace Modules\Admin\Repositories;

use Modules\Mon\Repositories\BaseRepository;

interface BoxAreaRepository extends BaseRepository
{
    public function getAllTree($parent_id = null, $request);
    public function getAllHierarchy($parent_id = null);
}
