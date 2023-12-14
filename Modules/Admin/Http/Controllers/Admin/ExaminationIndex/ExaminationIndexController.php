<?php

namespace Modules\Admin\Http\Controllers\Admin\ExaminationIndex;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\ExaminationIndex;
use Modules\Admin\Repositories\ExaminationIndexRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\AdminController;

class ExaminationIndexController extends AdminController
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$examinationindices = $this->examinationindex->all();

        return $this->view('admin::examinationindices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return $this->view('admin::examinationindices.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  ExaminationIndex $examinationindex
     * @return Response
     */
    public function edit(ExaminationIndex $examinationindex)
    {
        return $this->view('admin::examinationindices.edit', compact('examinationindex'));
    }


}
