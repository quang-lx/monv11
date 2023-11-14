<?php

namespace Modules\Admin\Http\Controllers\Admin\ConfigDisplay;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\ConfigDisplay;
use Modules\Admin\Repositories\ConfigDisplayRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\AdminController;

class ConfigDisplayController extends AdminController
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$configdisplays = $this->configdisplay->all();

        return $this->view('admin::configdisplays.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return $this->view('admin::configdisplays.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  ConfigDisplay $configdisplay
     * @return Response
     */
    public function edit(ConfigDisplay $configdisplay)
    {
        return $this->view('admin::configdisplays.edit', compact('configdisplay'));
    }


}
