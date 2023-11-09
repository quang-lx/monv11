<?php

namespace Modules\Admin\Http\Controllers\Admin\Department;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\Department;
use Modules\Admin\Repositories\DepartmentRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\AdminController;

class DepartmentController extends AdminController
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$departments = $this->department->all();

        return $this->view('admin::departments.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return $this->view('admin::departments.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  Department $department
     * @return Response
     */
    public function edit(Department $department)
    {
        return $this->view('admin::departments.edit', compact('department'));
    }


}
