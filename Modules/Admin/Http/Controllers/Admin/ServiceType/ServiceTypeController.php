<?php

namespace Modules\Admin\Http\Controllers\Admin\ServiceType;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\ServiceType;
use Modules\Admin\Repositories\ServiceTypeRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\AdminController;

class ServiceTypeController extends AdminController
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$servicetypes = $this->servicetype->all();

        return $this->view('admin::servicetypes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return $this->view('admin::servicetypes.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  ServiceType $servicetype
     * @return Response
     */
    public function edit(ServiceType $servicetype)
    {
        return $this->view('admin::servicetypes.edit', compact('servicetype'));
    }


}
