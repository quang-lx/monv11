<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Media\Traits\MediaRelation;

/**
 * Class BangThietBi
 * @property $name
 * @property $status
 * @property $total_device
 * @property $created_by
 * @package Modules\Mon\Entities
 */
class BangThietBi extends Model
{

    protected $table = 'bang_thiet_bi';
    protected $fillable = ['name', 'status', 'total_device', 'created_by'];


}
