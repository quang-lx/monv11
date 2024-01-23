<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;

class ExaminationHealth extends Model
{

    protected $table = 'examination_health';
    protected $fillable = [
        'patient_id','examination_id', 'create_date', 'height', 'weight', 'bmi', 'blood_pressure', 'heart_beat', 'note',
        'spo2'
    ];

    public function patient() {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function examination() {
        return $this->belongsTo(PatientExamination::class, 'examination_id');
    }
}
