<?php

namespace Modules\Admin\Http\Controllers\Api\ConfigDisplay;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\ConfigDisplay;
use Modules\Admin\Http\Requests\ConfigDisplay\CreateConfigDisplayRequest;
use Modules\Admin\Http\Requests\ConfigDisplay\UpdateConfigDisplayRequest;
use Modules\Admin\Repositories\ConfigDisplayRepository;
use Modules\Admin\Transformers\ConfigDisplayTransformer;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class ConfigDisplayController extends ApiController
{
    /**
     * @var ConfigDisplayRepository
     */
    private $configdisplayRepository;

    public function __construct(Authentication $auth, ConfigDisplayRepository $configdisplay)
    {
        parent::__construct($auth);

        $this->configdisplayRepository = $configdisplay;
    }


    public function index(Request $request)
    {
        return ConfigDisplayTransformer::collection($this->configdisplayRepository->serverPagingFor($request));
    }


    public function all(Request $request)
    {
        return ConfigDisplayTransformer::collection($this->configdisplayRepository->newQueryBuilder()->get());
    }


    public function store(CreateConfigDisplayRequest $request)
    {
        $this->configdisplayRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::configdisplay.message.create success'),
        ]);
    }


    public function find(ConfigDisplay $configdisplay)
    {
        return new  ConfigDisplayFullTransformer($configdisplay);
    }

    public function update(ConfigDisplay $configdisplay, UpdateConfigDisplayRequest $request)
    {
        $this->configdisplayRepository->update($configdisplay, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::configdisplay.message.update success'),
        ]);
    }

    public function destroy(ConfigDisplay $configdisplay)
    {
        $this->configdisplayRepository->destroy($configdisplay);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::configdisplay.message.delete success'),
        ]);
    }
}
