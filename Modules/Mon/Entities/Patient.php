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
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function examinations()
    {
        return $this->hasMany(PatientExamination::class, 'patient_id');
    }

    public function getCurrentExaminationAttribute()
    {
        return $this->examinations()->orderByDesc('id')->first();
    }

    public function getPatientInfo() {
        return [
            'name' => $this->name,
            'sex' => $this->sex,
            'sex_text' => $this->sex == 1 ? 'Nam' : 'Nữ',
            'birthday' => \DateTime::createFromFormat('Y-m-d H:i:s', $this->birthday)->format('Y-m-d'),
            'phone' => $this->phone,
            'email' => $this->email,
            'papers' => $this->papers,
            'job' => $this->job,
            'address' => $this->address,
            'dependant' => $this->dependant,
            'phone_dependant' => $this->phone_dependant,
            'data_sources' => $this->data_sources == Patient::Local ? 'Local' : 'LIS',

            'diagnose' => optional($this->current_examination)->diagnose,
        ];
    }

    public function hasExaminationNotDone() {
        return $this->examinations()->where('status', '<>', PatientExamination::STATUS_DONE)->count();
    }
}
