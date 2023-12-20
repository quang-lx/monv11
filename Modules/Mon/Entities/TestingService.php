<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TestingService
 * @property $code
 * @property $code_lis
 * @property $name
 * @property $type
 * @property $min_value
 * @property $max_value
 * @property $ref_value
 * @property $male_min_value
 * @property $male_max_value
 * @property $unit
 * @property $female_min_value
 * @property $female_max_value
 * @property $serviceIndexes
 * @package Modules\Mon\Entities
 */
class TestingService extends Model
{

    protected $table = 'testing_service';
    protected $fillable = [
        'code', 'code_lis', 'name', 'type', 'min_value', 'max_value', 'ref_value',
        'male_min_value', 'male_max_value', 'unit', 'female_min_value', 'female_max_value'
    ];

    protected $appends = ['type_name'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function serviceType() {
        return $this->belongsTo(\Modules\Mon\Entities\ServiceType::class, 'type');
    }

    public function serviceIndexes() {
        return $this->hasMany(ServiceIndex::class, 'service_id');
    }
    protected function getTypeNameAttribute()
    {
        return optional($this->serviceType)->name;
    }
}
