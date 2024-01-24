<?php

namespace Modules\Admin\Http\Controllers\Admin\Box;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\Box;
use Modules\Admin\Repositories\BoxRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\AdminController;

class BoxController extends AdminController
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$boxes = $this->box->all();

        return $this->view('admin::boxes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return $this->view('admin::boxes.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  Box $box
     * @return Response
     */
    public function edit(Box $box)
    {
        return $this->view('admin::boxes.edit', compact('box'));
    }


}
