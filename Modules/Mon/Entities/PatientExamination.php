<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PatientExamination
 * @property $started_at
 * @property $finished_at
 * @property $status
 * @property $diagnose
 * @property $status_text
 * @property $status_color
 * @property $created_by
 * @property $patient_id
 * @property $patient
 * @property $createdBy
 * @package Modules\Mon\Entities
 */
class PatientExamination extends Model
{
    const  STATUS_INIT = 'init';
    const  STATUS_PROCESSING = 'processing';
    const  STATUS_DONE = 'done';

    public $appends = ['status_text', 'status_color'];

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
    public function services() {
        return $this->hasMany(ExaminationService::class, 'examination_id');
    }

    public function getStatusTextAttribute() {
        return self::mapStatusText($this->status);

    }
    public function getStatusColorAttribute() {
        return self::mapStatusColor($this->status);

    }
    public static function mapStatusText($status) {
        $name = '';
        switch ($status) {
            case self::STATUS_INIT:
                $name = 'Tiếp đón';
                break;
            case self::STATUS_PROCESSING:
                $name = 'Đang khám';
                break;
            case self::STATUS_DONE:
                $name = 'Hoàn thành';
                break;

        }
        return $name;
    }
    public static function mapStatusColor($status) {
        $color = '#007AFF6E';
        switch ($status) {
            case self::STATUS_INIT:
                $color = '#007AFF6E';
                break;
            case self::STATUS_PROCESSING:
                $color = '#E1C14C';
                break;
            case self::STATUS_DONE:
                $color = '#A4E381';
                break;

        }
        return $color;
    }
}
