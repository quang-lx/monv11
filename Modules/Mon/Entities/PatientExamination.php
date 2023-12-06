<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PatientExamination
 * @property $started_at
 * @property $finished_at
 * @property $status
 * @property $diagnose
 * @property $created_by
 * @property $patient_id
 * @property $patient
 * @property $createdBy
 * @package Modules\Mon\Entities
 */
class PatientExamination extends Model
{
    const  STATUS_INIT = 'init';

    protected $table = 'patient_examination';
    protected $fillable = [
       'patient_id', 'started_at', 'finished_at', 'status', 'diagnose', 'created_by'
    ];

    public function createdBy () {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function patient () {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
