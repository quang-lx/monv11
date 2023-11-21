<?php

namespace Modules\Admin\Http\Controllers\Api\TestingService;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Transformers\TestingServiceTransformer;
use Modules\Mon\Entities\TestingService;
use Modules\Admin\Http\Requests\TestingService\CreateTestingServiceRequest;
use Modules\Admin\Http\Requests\TestingService\UpdateTestingServiceRequest;
use Modules\Admin\Repositories\TestingServiceRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class TestingServiceController extends ApiController
{
    /**
     * @var TestingServiceRepository
     */
    private $testingserviceRepository;

    public function __construct(Authentication $auth, TestingServiceRepository $testingservice)
    {
        parent::__construct($auth);

        $this->testingserviceRepository = $testingservice;
    }


    public function index(Request $request)
    {
        return TestingServiceTransformer::collection($this->testingserviceRepository->serverPagingFor($request));
    }


    public function all(Request $request)
    {
        return TestingServiceTransformer::collection($this->testingserviceRepository->newQueryBuilder()->get());
    }


    public function store(CreateTestingServiceRequest $request)
    {
        $this->testingserviceRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::service.message.create success'),
        ]);
    }


    public function find(TestingService $testingservice)
    {
        return new  TestingServiceTransformer($testingservice);
    }

    public function update(TestingService $testingservice, UpdateTestingServiceRequest $request)
    {
        $this->testingserviceRepository->update($testingservice, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::service.message.update success'),
        ]);
    }

    public function destroy(TestingService $testingservice)
    {
        $this->testingserviceRepository->destroy($testingservice);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::service.message.delete success'),
        ]);
    }
}
