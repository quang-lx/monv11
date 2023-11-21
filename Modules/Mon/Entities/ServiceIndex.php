<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ServiceIndex
 * @property $service_id
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
 * @property $testingService TestingService
 * @package Modules\Mon\Entities
 */
class ServiceIndex extends Model
{

    protected $table = 'testing_service_index';
    protected $fillable = [
        'service_id','code', 'code_lis', 'name', 'type', 'min_value', 'max_value', 'ref_value',
        'male_min_value', 'male_max_value', 'unit', 'female_min_value', 'female_max_value'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function testingService() {
        return $this->belongsTo(TestingService::class, 'service_id');
    }
}
