<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    public $appends = ['status_text'];

    protected $table = 'box';
    protected $fillable = [
        'area_id', 'name', 'status', 'code', 'note'
    ];

    public function area() {
        return $this->belongsTo(BoxArea::class, 'area_id');
    }

    public function getStatusTextAttribute() {
        if($this->status == 1) {
            return 'Đang hoạt động';
        } else {
            return 'Không hoạt động';
        }
    }
}
