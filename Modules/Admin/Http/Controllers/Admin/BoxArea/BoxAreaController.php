<?php

namespace Modules\Admin\Http\Controllers\Admin\BoxArea;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\BoxArea;
use Modules\Admin\Repositories\BoxAreaRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\AdminController;

class BoxAreaController extends AdminController
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$boxareas = $this->boxarea->all();

        return $this->view('admin::boxareas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return $this->view('admin::boxareas.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  BoxArea $boxarea
     * @return Response
     */
    public function edit(BoxArea $boxarea)
    {
        return $this->view('admin::boxareas.edit', compact('boxarea'));
    }


}
