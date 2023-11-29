<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ServiceType
 * @property  $code
 * @property  $name
 * @property  $description
 * @package Modules\Mon\Entities
 */
class ServiceType extends Model
{

    protected $table = 'service_type';
    protected $fillable = [
        'code', 'name', 'description'
    ];
}
