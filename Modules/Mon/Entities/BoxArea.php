<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;
/**
 * Class BoxArea
 * @property  $name
 * @property  $parent_id
 * @property  $not_assign
 * @package Modules\Mon\Entities
 */
class BoxArea extends Model
{

    protected $table = 'box_area';
    protected $fillable = ['name', 'parent_id', 'not_assign'];
}
