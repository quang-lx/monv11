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
 * @property $type
 * @property $type_text
 * @property $patient
 * @property $disease_id
 * @property $createdBy
 * @property $from_source
 * @package Modules\Mon\Entities
 */
class PatientExamination extends Model
{
    const  STATUS_INIT = 'init';
    const  STATUS_PROCESSING = 'processing';
    const  STATUS_DONE = 'done';

    const TYPE_NEW = 0;
    const TYPE_AGAIN = 1;

    const SOURCE_LOCAL = 1;
    const SOURCE_LIS = 2;

    public $appends = ['status_text', 'status_color', 'status_class', 'type_text', 'source_text'];
    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];
    protected $table = 'patient_examination';
    protected $fillable = [
       'patient_id', 'started_at', 'finished_at', 'status', 'diagnose', 'created_by', 'type', 'disease_id', 'from_source'
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
    public function disease() {
        return $this->belongsTo(Disease::class, 'disease_id');
    }

    public function getStatusTextAttribute() {
        return self::mapStatusText($this->status);

    }
    public function getStatusColorAttribute() {
        return self::mapStatusColor($this->status);

    }
    public function getStatusClassAttribute() {
        return self::mapStatusClass($this->status);

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

    public static function mapStatusClass($status) {
        $class= '';
        switch ($status) {
            case self::STATUS_INIT:
                $class = 'examination-init';
                break;
            case self::STATUS_PROCESSING:
                $class = 'examination-processing';
                break;
            case self::STATUS_DONE:
                $class = 'examination-done';
                break;

        }
        return $class;
    }

    public function getTypeTextAttribute() {
        $class= '';
        switch ($this->type) {
            case self::TYPE_NEW:
                $class = 'Khám mới';
                break;
            default:
                $class = 'Tái khám';
                break;

        }
        return $class;
    }

    public function getSourceTextAttribute() {
        return $this->from_source == self::SOURCE_LIS? 'Lis': 'Local';
    }
}
