<?php

namespace Modules\Admin\Http\Controllers\Admin\ServiceIndex;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\ServiceIndex;
use Modules\Admin\Repositories\ServiceIndexRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\AdminController;

class ServiceIndexController extends AdminController
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$serviceindices = $this->serviceindex->all();

        return $this->view('admin::serviceindices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return $this->view('admin::serviceindices.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  ServiceIndex $serviceindex
     * @return Response
     */
    public function edit(ServiceIndex $serviceindex)
    {
        return $this->view('admin::serviceindices.edit', compact('serviceindex'));
    }


}
