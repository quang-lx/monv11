<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ExaminationIndex
 * @property $service_id
 * @property $examination_id
 * @property $service_index_id
 * @property $result_at
 * @property $ket_qua
 * @property $ket_luan
 * @property $result_by
 * @property $resultBy
 * @package Modules\Mon\Entities
 */
class ExaminationIndex extends Model
{

    protected $table = 'examination_service_index';
    protected $fillable = [
        'service_id','examination_id','service_index_id','result_at','ket_qua','ket_luan', 'result_by'
    ];
    public function resultBy()
    {
        return $this->belongsTo(User::class, 'result_by');
    }

}
