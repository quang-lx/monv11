<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Device
 * @property $name
 * @property $code
 * @property $type
 * @property $serial_number
 * @property $note
 * @property $box
 * @property $status
 * @package Modules\Mon\Entities
 */
class Device extends Model
{

    protected $table = 'device';
    protected $fillable = [
        'name', 'code', 'type', 'serial_number', 'note', 'box', 'status'
    ];
}
