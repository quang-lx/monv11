<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{

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
        'created_by',
        'created_at',
        'updated_at'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
