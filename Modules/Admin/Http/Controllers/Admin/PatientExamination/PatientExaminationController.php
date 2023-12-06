<?php

namespace Modules\Admin\Http\Controllers\Admin\PatientExamination;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\PatientExamination;
use Modules\Admin\Repositories\PatientExaminationRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\AdminController;

class PatientExaminationController extends AdminController
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$patientexaminations = $this->patientexamination->all();

        return $this->view('admin::patientexaminations.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return $this->view('admin::patientexaminations.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  PatientExamination $patientexamination
     * @return Response
     */
    public function edit(PatientExamination $patientexamination)
    {
        return $this->view('admin::patientexaminations.edit', compact('patientexamination'));
    }


}
