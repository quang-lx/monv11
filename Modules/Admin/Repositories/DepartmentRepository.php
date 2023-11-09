<?php

namespace Modules\Admin\Repositories;

use Modules\Mon\Repositories\BaseRepository;

interface DepartmentRepository extends BaseRepository
{
    public function getAllTree($parent_id = null);

}
