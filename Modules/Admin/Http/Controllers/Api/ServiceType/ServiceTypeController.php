<?php

namespace Modules\Admin\Http\Controllers\Api\ServiceType;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Transformers\ServiceTypeTransformer;
use Modules\Mon\Entities\ServiceType;
use Modules\Admin\Http\Requests\ServiceType\CreateServiceTypeRequest;
use Modules\Admin\Http\Requests\ServiceType\UpdateServiceTypeRequest;
use Modules\Admin\Repositories\ServiceTypeRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class ServiceTypeController extends ApiController
{
    /**
     * @var ServiceTypeRepository
     */
    private $servicetypeRepository;

    public function __construct(Authentication $auth, ServiceTypeRepository $servicetype)
    {
        parent::__construct($auth);

        $this->servicetypeRepository = $servicetype;
    }


    public function index(Request $request)
    {
        return ServiceTypeTransformer::collection($this->servicetypeRepository->serverPagingFor($request));
    }


    public function all(Request $request)
    {
        return ServiceTypeTransformer::collection($this->servicetypeRepository->newQueryBuilder()->get());
    }


    public function store(CreateServiceTypeRequest $request)
    {
        $this->servicetypeRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::servicetype.message.create success'),
        ]);
    }


    public function find(ServiceType $servicetype)
    {
        return new  ServiceTypeTransformer($servicetype);
    }

    public function update(ServiceType $servicetype, UpdateServiceTypeRequest $request)
    {
        $this->servicetypeRepository->update($servicetype, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::servicetype.message.update success'),
        ]);
    }

    public function destroy(ServiceType $servicetype)
    {
        $this->servicetypeRepository->destroy($servicetype);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::servicetype.message.delete success'),
        ]);
    }
}
