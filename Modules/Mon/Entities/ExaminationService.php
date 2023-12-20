<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ExaminationService
 * @property $patient_id
 * @property $examination_id
 * @property $service_id
 * @property $status
 * @property $status_text
 * @property $created_by
 * @property $result_at
 * @property $ket_qua
 * @property $ket_luan
 * @property $result_by_id
 * @property $from_source
 * @property $result_by
 * @property $testingService
 * @property $resultBy
 * @property $user
 * @package Modules\Mon\Entities
 */
class ExaminationService extends Model
{
    const STATUS_NEW = 1;
    const STATUS_PROCESSING = 2;
    const STATUS_DONE = 3;
    const STATUS_CANCEL = 4;
    public $appends = ['status_text', 'status_color'];
    protected $table = 'examination_service';
    protected $fillable = [
        'patient_id',
        'examination_id',
        'service_id',
        'status',
        'created_by',
        'created_at',
        'updated_at',
        'result_at',
        'ket_qua',
        'ket_luan', 'result_by_id', 'from_source','result_by'
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::created(function (ExaminationService $model) {
            $list_service_index = ServiceIndex::query()->where('service_id', $model->service_id)->get();
            foreach ($list_service_index as $index_model) {
                ExaminationIndex::create([
                    'service_id' => $model->service_id,
                    'examination_id' => $model->examination_id,
                    'service_index_id' => $index_model->id,

                ]);
            }
        });
    }

    public function testingService()
    {
        return $this->belongsTo(TestingService::class, 'service_id');
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function resultBy()
    {
        return $this->belongsTo(User::class, 'result_by');
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
            case self::STATUS_NEW:
                $name = 'Mới';
                break;
            case self::STATUS_PROCESSING:
                $name = 'Đang thực hiện';
                break;
            case self::STATUS_DONE:
                $name = 'Đã có kết quả';
                break;
            case self::STATUS_CANCEL:
                $name = 'Đã huỷ';
                break;
        }
        return $name;
    }
    public static function mapStatusColor($status) {
        $color = '#007AFF';
        switch ($status) {
            case self::STATUS_NEW:
                $color = '#007AFF';
                break;
            case self::STATUS_PROCESSING:
                $color = '#E1C14C';
                break;
            case self::STATUS_DONE:
                $color = '#21A366';
                break;
            case self::STATUS_CANCEL:
                $color = '#FF0000';
                break;
        }
        return $color;
    }
}
