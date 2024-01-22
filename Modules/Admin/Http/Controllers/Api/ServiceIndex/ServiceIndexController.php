<?php

namespace Modules\Admin\Http\Controllers\Api\ServiceIndex;

use App\Exports\ServiceIndexErrorExport;
use App\Exports\ServiceIndexExport;
use App\Imports\ImportServiceIndex;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Transformers\ServiceIndexTransformer;
use Modules\Mon\Entities\ServiceIndex;
use Modules\Admin\Http\Requests\ServiceIndex\CreateServiceIndexRequest;
use Modules\Admin\Http\Requests\ServiceIndex\UpdateServiceIndexRequest;
use Modules\Admin\Repositories\ServiceIndexRepository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Admin\Http\Requests\Excel\ExcelUploadRequest;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;
use Illuminate\Support\Facades\Log;

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
        $model = $this->serviceindexRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'id' => $model->id,
            'message' => trans('backend::serviceindex.message.create success'),
        ]);
    }


    public function find(ServiceIndex $serviceindex)
    {
        return new ServiceIndexTransformer($serviceindex);
    }

    public function update(ServiceIndex $serviceindex, UpdateServiceIndexRequest $request)
    {
        $this->serviceindexRepository->update($serviceindex, $request->all());

        return response()->json([
            'errors' => false,
            'id' => $serviceindex->id,
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

    public function exports(Request $request)
    {
        $time_now = Carbon::now()->timestamp;
        Excel::store(new ServiceIndexExport($request), '/public/media/' . 'serviceindex_' . $time_now . '.xlsx');
        $fileUrl = url('storage/media/' . 'serviceindex_' . $time_now . '.xlsx');
        return response()->json(['success' => true, 'fileUrl' => $fileUrl]);
    }

    public function imports(ExcelUploadRequest $request)
    {
        $import = new ImportServiceIndex();
        Excel::import($import, $request->file('file'));
        $service_id = $request->get('service_id');
        $data_disease = $import->getDataImport();
        $list_error = [];

        DB::transaction(function () use ($request, &$data_disease, &$list_error, $service_id) {

            foreach ($data_disease as $key => $disease) {
                try {
                    $message_error = $this->validateData($disease);
                    if ($message_error) {
                        throw new \Exception($message_error);
                    }
                    $service_index_model = new ServiceIndex();
                    $service_index_model->code = $disease['code'];
                    $service_index_model->code_lis = $disease['code_lis'];
                    $service_index_model->name = $disease['name'];
                    $service_index_model->ref_value = $disease['ref_value'];
                    $service_index_model->male_min_value = $disease['male_min_value'];
                    $service_index_model->male_max_value = $disease['male_max_value'];
                    $service_index_model->female_min_value = $disease['female_min_value'];
                    $service_index_model->female_max_value = $disease['female_max_value'];
                    $service_index_model->min_value = $disease['min_value'];
                    $service_index_model->max_value = $disease['max_value'];
                    $service_index_model->unit = $disease['unit'];
                    $service_index_model->service_id = $service_id;
                    $service_index_model->save();
                } catch (\Throwable $th) {
                    Log::info($th->getMessage());
                    $disease['error'] = $th->getMessage();
                    $list_error[] = $disease;
                }
            }
        });
        $time_now = Carbon::now()->timestamp;
        Excel::store(new ServiceIndexErrorExport($list_error), 'public/media/' . 'chi_so_con_loi_' . $time_now . '.xlsx');
        $fileUrl = url('storage/media/' . 'chi_so_con_loi_' . $time_now . '.xlsx');
        return response()->json([
            'success' => true,
            'message' => trans('backend::serviceindex.message.import success'),
            'total' => count($data_disease),
            'fileUrl' => $fileUrl,
            'total_success' => (count($data_disease) - count($list_error))
        ]);
    }

    public function validateData($service)
    {
        if (ServiceIndex::where('code', $service['code'])->first()) {
            return trans('backend::service.label.code') . trans('backend::mon.error.unique');
        }
        if (!$service['code']) {
            return trans('backend::service.label.code') . trans('backend::mon.error.required');
        }

        if (!$service['code_lis']) {
            return trans('backend::service.label.code_lis') . trans('backend::mon.error.required');
        }

        if (!$service['name']) {
            return trans('backend::service.label.name') . trans('backend::mon.error.required');
        }

        if ($service['ref_value'] && !is_numeric($service['ref_value'])) {
            return trans('backend::service.label.ref_value') . trans('backend::mon.error.numberic');
        }

        if ($service['male_min_value'] && !is_numeric($service['male_min_value'])) {
            return trans('backend::service.label.male_min_value') . trans('backend::mon.error.numberic');
        }

        if ($service['male_max_value'] && !is_numeric($service['male_max_value'])) {
            return trans('backend::service.label.male_max_value') . trans('backend::mon.error.numberic');
        }

        if ($service['female_min_value'] && !is_numeric($service['female_min_value'])) {
            return trans('backend::service.label.female_min_value') . trans('backend::mon.error.numberic');
        }

        if ($service['female_max_value'] && !is_numeric($service['female_max_value'])) {
            return trans('backend::service.label.female_max_value') . trans('backend::mon.error.numberic');
        }

        if ($service['min_value'] && !is_numeric($service['min_value'])) {
            return trans('backend::service.label.min_value') . trans('backend::mon.error.numberic');
        }

        if ($service['max_value'] && !is_numeric($service['max_value'])) {
            return trans('backend::service.label.max_value') . trans('backend::mon.error.numberic');
        }

        return null;
    }
}
