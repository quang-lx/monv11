<?php

namespace Modules\Admin\Http\Controllers\Admin\ExaminationService;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\ExaminationService;
use Modules\Admin\Repositories\ExaminationServiceRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\AdminController;

class ExaminationServiceController extends AdminController
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$examinationservices = $this->examinationservice->all();

        return $this->view('admin::examinationservices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return $this->view('admin::examinationservices.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  ExaminationService $examinationservice
     * @return Response
     */
    public function edit(ExaminationService $examinationservice)
    {
        return $this->view('admin::examinationservices.edit', compact('examinationservice'));
    }


}
