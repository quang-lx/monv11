<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ExaminationIndex
 * @property $service_id
 * @property $examination_id
 * @property $service_index_id
 * @property $result_at
 * @property $ket_qua
 * @property $ket_luan
 * @property $id_lis
 * @property $examination_service_id
 * @property $result_by
 * @property $resultBy
 * @package Modules\Mon\Entities
 */
class ExaminationIndex extends Model
{
    use SoftDeletes;

    protected $table = 'examination_service_index';
    protected $fillable = [
        'service_id','examination_id','service_index_id','result_at','ket_qua','ket_luan', 'result_by', 'examination_service_id', 'id_lis'
    ];
    public function resultBy()
    {
        return $this->belongsTo(User::class, 'result_by');
    }

    public function indexModel() {
        return $this->belongsTo(ServiceIndex::class, 'service_index_id');
    }

}
