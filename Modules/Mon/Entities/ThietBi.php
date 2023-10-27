<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Media\Traits\MediaRelation;

/**
 * Class BangThietBi
 * @property $bang_thiet_bi_id
 * @property $ma_ke_khai
 * @property $ten_thiet_bi
 * @property $hang_sx
 * @property $nuoc_sx
 * @property $chung_loai
 * @property $search_status
 * @package Modules\Mon\Entities
 */
class ThietBi extends Model
{

    protected $table = 'thiet_bi';
    protected $fillable = ['bang_thiet_bi_id', 'ma_ke_khai', 'ten_thiet_bi', 'hang_sx', 'nuoc_sx', 'chung_loai', 'search_status'];


}
