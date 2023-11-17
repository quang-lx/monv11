<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Department
 * @property  $name
 * @property  $parent_id
 * @property  $not_assign
 * @package Modules\Mon\Entities
 */
class Department extends Model
{

    protected $table = 'department';
    protected $fillable = ['name', 'parent_id', 'not_assign'];
}
