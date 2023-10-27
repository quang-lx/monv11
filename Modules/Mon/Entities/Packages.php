<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Packages extends Model
{
    use SoftDeletes;

    protected $table = 'packages';
    protected $fillable = ['name', 'period_time', 'price', 'status'];
}
