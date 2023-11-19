<?php

namespace Modules\Admin\Http\Controllers\Api\Device;

use App\Exports\DevicesErrorExport;
use App\Exports\DevicesExport;
use App\Imports\ImportDevices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Transformers\DeviceTransformer;
use Modules\Mon\Entities\Device;
use Modules\Admin\Http\Requests\Device\CreateDeviceRequest;
use Modules\Admin\Http\Requests\Device\UpdateDeviceRequest;
use Modules\Admin\Repositories\DeviceRepository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Admin\Http\Requests\Excel\ExcelUploadRequest;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;
use Illuminate\Support\Facades\Log;

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

    public function exports(Request $request)
    {
        $time_now = Carbon::now()->timestamp;
        Excel::store(new DevicesExport($request), '/public/media/' . 'device_' . $time_now . '.xlsx');
        $fileUrl = url('storage/media/' . 'device_' . $time_now . '.xlsx');
        return response()->json(['success' => true, 'fileUrl' => $fileUrl]);
    }

    public function imports(ExcelUploadRequest $request)
    {
        $import = new ImportDevices($request);
        Excel::import($import, $request->file('file'));
        $data_device = $import->getDataImport();
        $list_error = [];

        DB::transaction(function () use ($request, &$data_device, &$list_error) {

            foreach ($data_device as $key => $device) {
                try {
                    $message_error = $this->validateData($device);
                    if ($message_error) {
                        throw new \Exception($message_error);
                    }
                    $device_model = new Device();
                    $device_model->code = $device['code'];
                    $device_model->name = $device['name'];
                    $device_model->type = $device['type'];
                    $device_model->serial_number = $device['serial_number'];
                    $device_model->note = $device['note'];
                    $device_model->save();
                } catch (\Throwable $th) {
                    Log::info($th->getMessage());
                    $device['error'] = $th->getMessage();
                    $list_error[] = $device;
                }
            }
        });
        $time_now = Carbon::now()->timestamp;
        Excel::store(new DevicesErrorExport($list_error), 'public/media/' . 'devices_error_' . $time_now . '.xlsx');
        $fileUrl = url('storage/media/' . 'devices_error_' . $time_now . '.xlsx');
        return response()->json([
            'success' => true,
            'message' => trans('backend::device.message.import success'),
            'total' => count($data_device),
            'fileUrl' => $fileUrl,
            'total_success' => (count($data_device) - count($list_error))
        ]);
    }

    public function validateData($device){
        if (!$device['code']) {
           return trans('backend::device.label.code').trans('backend::mon.error.required');
        }
        return null;
    }
}
