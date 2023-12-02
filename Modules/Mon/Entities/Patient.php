<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{

    const Local = 1;
    const LIS = 2;

    const STATUS_RECEIVE = 1;
    const STATUS_PROCESSING = 1;
    const STATUS_DONE = 3;
    protected $table = 'patient';
    protected $fillable = [
        'id',
        'name',
        'sex',
        'birthday',
        'phone',
        'email',
        'papers',
        'job',
        'address',
        'dependant',
        'phone_dependant',
        'data_sources',
        'status',
        'diagnose',
        'created_by',
        'created_at',
        'updated_at'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
