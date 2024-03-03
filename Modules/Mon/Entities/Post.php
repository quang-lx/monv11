<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\Traits\MediaRelation;

/**
 * Class Post
 * @property $name
 * @property $option
 * @property $sex

 * @package Modules\Mon\Entities
 */
class Post extends Model
{
    use MediaRelation;

    protected $table = 'post';
    protected $fillable = [
        'name',
        'option',
        'sex'
    ];
}
