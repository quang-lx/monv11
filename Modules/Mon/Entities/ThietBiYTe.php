<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Media\Traits\MediaRelation;

/**
 * Class ThietBiYTe
 * @property  $nuoc_san_xuat
 * @package Modules\Mon\Entities
 */
class ThietBiYTe extends Model
{
    use  SoftDeletes;

    protected $keyType = 'string';
    protected $primaryKey = 'ma_ke_khai';
    protected $table = 'kekhai_thietbiyte';
    protected $fillable = ['ma_ke_khai', 'origin_url', 'ten_doanh_nghiep', 'lien_he_doanh_nghiep', 'email_doanh_nghiep', 'ten_thiet_bi', 'ten_thuong_mai',
        'ma_gmdn', 'chung_loai', 'ma_sp', 'nuoc_chu_so_huu', 'nuoc_san_xuat', 'don_vi_tinh', 'quy_cach_dong_goi', 'tinh_nang_ky_thuat',
        'gia_ban_toi_da', 'hieu_luc_tu', 'hieu_luc_den', 'giay_phep_nhap_khau', 'ngay_cap_phep', 'ngay_ke_khai', 'crawler_status', 'es_status','hang_sx', 'hang_chu_so_huu',
        'type'
        ];


}
