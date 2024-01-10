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
        'code', 'name', 'description', 'created_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function services() {
        return $this->hasMany(TestingService::class, 'type');
    }
}
