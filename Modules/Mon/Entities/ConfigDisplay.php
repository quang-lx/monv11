<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Media\Traits\MediaRelation;

/**
 * Class ConfigDisplay
 * @property $col_name
 * @property $table_name
 * @property $position
 * @package Modules\Mon\Entities
 */
class ConfigDisplay extends Model
{


    protected $table = '';
    protected $fillable = ['col_name', 'table_name', 'position'];

}
