<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Media\Traits\MediaRelation;

/**
 * Class Country
 * @property name
 * @package Modules\Mon\Entities
 */
class Country extends Model
{

    protected $table = 'countries';
    protected $fillable = ['name'];


}
