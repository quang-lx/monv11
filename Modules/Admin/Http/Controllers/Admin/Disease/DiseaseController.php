<?php

namespace Modules\Admin\Http\Controllers\Admin\Disease;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\Disease;
use Modules\Admin\Repositories\DiseaseRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\AdminController;

class DiseaseController extends AdminController
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$diseases = $this->disease->all();

        return $this->view('admin::diseases.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return $this->view('admin::diseases.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  Disease $disease
     * @return Response
     */
    public function edit(Disease $disease)
    {
        return $this->view('admin::diseases.edit', compact('disease'));
    }


}
