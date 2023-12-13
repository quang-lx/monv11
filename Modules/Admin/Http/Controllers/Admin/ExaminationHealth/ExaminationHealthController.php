<?php

namespace Modules\Admin\Http\Controllers\Admin\ExaminationHealth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\ExaminationHealth;
use Modules\Admin\Repositories\ExaminationHealthRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\AdminController;

class ExaminationHealthController extends AdminController
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$examinationhealths = $this->examinationhealth->all();

        return $this->view('admin::examinationhealths.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return $this->view('admin::examinationhealths.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  ExaminationHealth $examinationhealth
     * @return Response
     */
    public function edit(ExaminationHealth $examinationhealth)
    {
        return $this->view('admin::examinationhealths.edit', compact('examinationhealth'));
    }


}
