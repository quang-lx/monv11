<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ExaminationService
 * @property $patient_id
 * @property $examination_id
 * @property $service_id
 * @property $status
 * @property $created_by
 * @property $testingService
 * @property $user
 * @package Modules\Mon\Entities
 */
class ExaminationService extends Model
{
    const STATUS_NEW = 1;

    protected $table = 'examination_service';
    protected $fillable = [
        'patient_id',
        'examination_id',
        'service_id',
        'status',
        'created_by',
        'created_at',
        'updated_at',
    ];

    public function testingService()
    {
        return $this->belongsTo(TestingService::class, 'service_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
