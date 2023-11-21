<?php

namespace Modules\Admin\Http\Controllers\Api\ServiceIndex;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\ServiceIndex;
use Modules\Admin\Http\Requests\ServiceIndex\CreateServiceIndexRequest;
use Modules\Admin\Http\Requests\ServiceIndex\UpdateServiceIndexRequest;
use Modules\Admin\Repositories\ServiceIndexRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class ServiceIndexController extends ApiController
{
    /**
     * @var ServiceIndexRepository
     */
    private $serviceindexRepository;

    public function __construct(Authentication $auth, ServiceIndexRepository $serviceindex)
    {
        parent::__construct($auth);

        $this->serviceindexRepository = $serviceindex;
    }


    public function index(Request $request)
    {
        return ServiceIndexTransformer::collection($this->serviceindexRepository->serverPagingFor($request));
    }


    public function all(Request $request)
    {
        return ServiceIndexTransformer::collection($this->serviceindexRepository->newQueryBuilder()->get());
    }


    public function store(CreateServiceIndexRequest $request)
    {
        $this->serviceindexRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::serviceindex.message.create success'),
        ]);
    }


    public function find(ServiceIndex $serviceindex)
    {
        return new  ServiceIndexFullTransformer($serviceindex);
    }

    public function update(ServiceIndex $serviceindex, UpdateServiceIndexRequest $request)
    {
        $this->serviceindexRepository->update($serviceindex, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::serviceindex.message.update success'),
        ]);
    }

    public function destroy(ServiceIndex $serviceindex)
    {
        $this->serviceindexRepository->destroy($serviceindex);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::serviceindex.message.delete success'),
        ]);
    }
}
