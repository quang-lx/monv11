<?php

namespace Modules\Admin\Http\Controllers\Admin\Patient;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\Patient;
use Modules\Admin\Repositories\PatientRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\AdminController;

class PatientController extends AdminController
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$patients = $this->patient->all();

        return $this->view('admin::patients.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return $this->view('admin::patients.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  Patient $patient
     * @return Response
     */
    public function edit(Patient $patient)
    {
        return $this->view('admin::patients.edit', compact('patient'));
    }


}
