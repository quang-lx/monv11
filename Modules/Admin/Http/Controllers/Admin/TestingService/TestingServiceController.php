<?php

namespace Modules\Admin\Http\Controllers\Admin\TestingService;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\TestingService;
use Modules\Admin\Repositories\TestingServiceRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\AdminController;

class TestingServiceController extends AdminController
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$testingservices = $this->testingservice->all();

        return $this->view('admin::testingservices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return $this->view('admin::testingservices.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  TestingService $testingservice
     * @return Response
     */
    public function edit(TestingService $testingservice)
    {
        return $this->view('admin::testingservices.edit', compact('testingservice'));
    }


}
