<?php

namespace Modules\Admin\Http\Controllers\Admin\Device;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\Device;
use Modules\Admin\Repositories\DeviceRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\AdminController;

class DeviceController extends AdminController
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$devices = $this->device->all();

        return $this->view('admin::devices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return $this->view('admin::devices.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  Device $device
     * @return Response
     */
    public function edit(Device $device)
    {
        return $this->view('admin::devices.edit', compact('device'));
    }


}
