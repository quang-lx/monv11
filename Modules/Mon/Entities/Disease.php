<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{

    protected $table = 'disease';
    protected $fillable = [
        'name', 'code', 'describe', 'created_by'
    ];
}
