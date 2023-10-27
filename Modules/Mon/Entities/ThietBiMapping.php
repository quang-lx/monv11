<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Media\Traits\MediaRelation;

/**
 * Class ThietBiMapping
 * @property $bang_thiet_bi_id
 * @property $thiet_bi_id
 * @property $ma_ke_khai
 * @property $relevance
 * @property $confirmed
 * @property $from_search
 * @package Modules\Mon\Entities
 */
class ThietBiMapping extends Model
{

    protected $table = 'thiet_bi_mapping';
    protected $fillable = ['bang_thiet_bi_id', 'thiet_bi_id', 'ma_ke_khai', 'relevance', 'confirmed', 'from_search'];


}
