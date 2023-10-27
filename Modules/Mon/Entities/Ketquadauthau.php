<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Media\Traits\MediaRelation;

class Ketquadauthau extends Model
{

    protected $table = 'ketquadauthau';
    protected $fillable = ['phan_nhom', 'so_luong', 'don_vi_tinh', 'don_gia', 'thanh_tien',
        'so_quyet_dinh', 'nguon_von_dau_tu',
        'so_luong_dinh_muc', 'chung_loai_model', 'giay_phep_nhap_khau',
        'nam_sx', 'nuoc_sx', 'hang_sx', 'nuoc_chu_so_huu', 'don_gia_trung_thau',
        'cau_hinh', 'don_vi_trung_thau', 'mst_don_vi_trung_thau', 'so_quyet_dinh_trung_thau',  'es_status'
        ];


}
