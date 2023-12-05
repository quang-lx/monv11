<?php

namespace Modules\Admin\Http\Controllers\Api\TestingService;

use App\Exports\DevicesErrorExport;
use App\Exports\ServiceErrorExport;
use App\Exports\TestingServiceExport;
use App\Imports\ImportDevices;
use App\Imports\ImportTestingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Admin\Http\Requests\Excel\ExcelUploadRequest;
use Modules\Admin\Transformers\TestingServiceTransformer;
use Modules\Mon\Entities\Device;
use Modules\Mon\Entities\ServiceIndex;
use Modules\Mon\Entities\ServiceType;
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
        $model = $this->testingserviceRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'id' => $model->id,
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
            'id' => $testingservice->id,
            'message' => trans('backend::service.message.update success'),
        ]);
    }

    public function destroy(TestingService $testingservice)
    {
        $result = $this->testingserviceRepository->destroy($testingservice);

        return response()->json([
            'errors' => $result? $result:false,
            'message' => $result? trans('backend::service.message.delete success'): trans('backend::common.server error'),
        ]);
    }

    public function imports(ExcelUploadRequest $request)
    {
        $import = new ImportTestingService();
        Excel::import($import, $request->file('file'));
        $data_service = $import->getDataImport();
        $list_error = [];

        foreach ($data_service as $key => $row) {
            try {
                $row_error = $row;
                $service_type = ServiceType::query()->where('name', $row['type'])->first();
                $row['type'] = optional($service_type)->id;
                DB::beginTransaction();
                $message_error = $this->validateData($row);
                $service_index_data = $row['index'];
                unset($row['index']);
                $row_error['index_code'] =$service_index_data['code']?? '';
                $row_error['index_name'] =$service_index_data['name']?? '';

                if ($message_error) {
                    throw new \Exception($message_error);
                }

                $testing_service = TestingService::query()->where('code' , $row['code'])->first();
                if (!$testing_service) {
                    $testing_service = new TestingService();
                }

                $testing_service->fill($row);
                $testing_service->save();

                if ($service_index_data) {
                    $service_index = ServiceIndex::query()->where('service_id', $testing_service->id)
                        ->where('code', $service_index_data['code'])->first();
                    if (!$service_index) {
                        $service_index = new ServiceIndex();
                    }
                    $service_index->fill($service_index_data);
                    $service_index->service_id = $testing_service->id;
                    $service_index->save();
                }

                DB::commit();
            } catch (\Throwable $th) {
                Log::info($th->getMessage());
                $row_error['error'] = $th->getMessage();
                $list_error[] = $row_error;
                DB::rollBack();
            }
        }
        $time_now = Carbon::now()->timestamp;
        Excel::store(new ServiceErrorExport($list_error), 'public/media/' . 'service_error_' . $time_now . '.xlsx');
        $fileUrl = url('storage/media/' . 'service_error_' . $time_now . '.xlsx');
        return response()->json([
            'success' => true,
            'message' => trans('backend::device.message.import success'),
            'total' => count($data_service),
            'fileUrl' => $fileUrl,
            'total_success' => (count($data_service) - count($list_error))
        ]);
    }

    public function validateData($item){
        $rules = [
            'code' => "required",
            'code_lis' => "required",
            'name' => "required",
            'type' => "required",

        ];
        $rule_message = [
            'code.required' => 'Mã dịch vụ là bắt buộc',
            'code_lis.required' => 'Mã gửi LIS là bắt buộc',
            'name.required' => 'Tên dịch vụ là bắt buộc',
            'type.required' => 'Loại dịch vụ là bắt buộc',
        ];
        $rule_index = [
            'code' => "required",
            'code_lis' => "required",
            'name' => "required",

        ];
        $rule_index_message = [
            'name.required' => 'Chỉ số con: Tên dịch vụ là bắt buộc',
            'code.required' => 'Chỉ số con: Mã dịch vụ là bắt buộc',
            'code_lis.required' => 'Chỉ số con: Mã gửi LIS là bắt buộc',

        ];

        $validator_service = Validator::make($item, $rules, $rule_message);
        if ($validator_service->fails()) {
            return $validator_service->errors()->first();
        }

        $index_data = $item['index']?? null;

        if(!empty($index_data)) {
            $validator_index = Validator::make($index_data, $rule_index, $rule_index_message);
            if ($validator_index->fails()) {
                return $validator_index->errors()->first();
            }
        }

        return null;
    }

    public function exports(Request $request)
    {
        $time_now = Carbon::now()->timestamp;
        Excel::store(new TestingServiceExport($request), '/public/media/' . 'danh_muc_dich_vu_' . $time_now . '.xlsx');
        $fileUrl = url('storage/media/' . 'danh_muc_dich_vu_' . $time_now . '.xlsx');
        return response()->json(['success' => true, 'fileUrl' => $fileUrl]);
    }
}
