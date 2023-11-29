<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;

class PatientHasService extends Model
{

    protected $table = 'patient_has_service';
    protected $fillable = [
        'id',
        'patient_id',
        'service_id',
        'status',
        'created_by',
        'created_at',
        'updated_at',
    ];

    public function testingService() {
        return $this->belongsTo(TestingService::class, 'service_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
