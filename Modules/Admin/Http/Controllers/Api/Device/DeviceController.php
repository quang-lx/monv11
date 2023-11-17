<?php

namespace Modules\Admin\Http\Controllers\Api\Device;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Transformers\DeviceTransformer;
use Modules\Mon\Entities\Device;
use Modules\Admin\Http\Requests\Device\CreateDeviceRequest;
use Modules\Admin\Http\Requests\Device\UpdateDeviceRequest;
use Modules\Admin\Repositories\DeviceRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class DeviceController extends ApiController
{
    /**
     * @var DeviceRepository
     */
    private $deviceRepository;

    public function __construct(Authentication $auth, DeviceRepository $device)
    {
        parent::__construct($auth);

        $this->deviceRepository = $device;
    }


    public function index(Request $request)
    {
        return DeviceTransformer::collection($this->deviceRepository->serverPagingFor($request));
    }


    public function all(Request $request)
    {
        return DeviceTransformer::collection($this->deviceRepository->newQueryBuilder()->get());
    }


    public function store(CreateDeviceRequest $request)
    {
        $this->deviceRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::device.message.create success'),
        ]);
    }


    public function find(Device $device)
    {
        return new  DeviceTransformer($device);
    }

    public function update(Device $device, UpdateDeviceRequest $request)
    {
        $this->deviceRepository->update($device, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::device.message.update success'),
        ]);
    }

    public function destroy(Device $device)
    {
        $this->deviceRepository->destroy($device);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::device.message.delete success'),
        ]);
    }
}
