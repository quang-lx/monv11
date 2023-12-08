<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Patient
 * @property $current_examination
 * @package Modules\Mon\Entities
 */
class Patient extends Model
{

    const Local = 1;
    const LIS = 2;


    protected $table = 'patient';
    protected $fillable = [
        'id',
        'name',
        'sex',
        'birthday',
        'phone',
        'email',
        'papers',
        'job',
        'address',
        'dependant',
        'phone_dependant',
        'data_sources',
        'created_by',
        'created_at',
        'updated_at'
    ];

    public $appends = ['current_examination'];
    public function user() {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function examinations() {
       return $this->hasMany(PatientExamination::class, 'patient_id');
    }

    public function getCurrentExaminationAttribute() {
       return $this->examinations()->orderByDesc('id')->first();
    }
}
