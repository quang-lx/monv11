<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\Traits\MediaRelation;

/**
 * Class Device
 * @property $name
 * @property $code
 * @property $type
 * @property $serial_number
 * @property $note
 * @property $box
 * @property $status
 * @property $doc_no
 * @package Modules\Mon\Entities
 */
class Device extends Model
{
    use MediaRelation;

    protected $table = 'device';
    protected $fillable = [
        'name', 'code', 'type', 'serial_number', 'note', 'box', 'status', 'doc_no'
    ];
}
