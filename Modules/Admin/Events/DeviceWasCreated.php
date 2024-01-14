<?php

namespace Modules\Admin\Events;

use Modules\Media\Repositories\StoringMedia;
use Modules\Mon\Entities\Device;


class DeviceWasCreated implements StoringMedia
{
    /**
     * @var Device
     */
    private $model;
    private $data;
    public function __construct(Device $model, $data)
    {
        $this->model = $model;
        $this->data = $data;
    }
    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->model;
    }

    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData()
    {
        return $this->data;
    }
}
