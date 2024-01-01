<?php

namespace Modules\Admin\Http\Controllers\Api\ServiceType;

use App\Exports\ErrorExport;
use App\Exports\ServiceTypeExport;
use App\Imports\ImportServiceType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Transformers\ServiceTypeTransformer;
use Modules\Mon\Entities\ServiceType;
use Modules\Admin\Http\Requests\ServiceType\CreateServiceTypeRequest;
use Modules\Admin\Http\Requests\ServiceType\UpdateServiceTypeRequest;
use Modules\Admin\Repositories\ServiceTypeRepository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Admin\Http\Requests\Excel\ExcelUploadRequest;
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
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;

        $this->servicetypeRepository->create($data);

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

    public function exports(Request $request)
    {
        $time_now = Carbon::now()->timestamp;
        Excel::store(new ServiceTypeExport($request), '/public/media/' . 'dich_vu_' . $time_now . '.xlsx');
        $fileUrl = url('storage/media/' . 'dich_vu_' . $time_now . '.xlsx');
        return response()->json(['success' => true, 'fileUrl' => $fileUrl]);
    }

    public function imports(ExcelUploadRequest $request)
    {
        $import = new ImportServiceType();
        Excel::import($import, $request->file('file'));
        $datas = $import->getDataImport();
        $list_error = [];

        DB::transaction(function () use ($request, &$datas, &$list_error) {

            foreach ($datas as $key => $data) {
                try {
                    $message_error = $this->validateData($data);
                    if ($message_error) {
                        throw new \Exception($message_error);
                    }
                    $model = new ServiceType();
                    $model->code = $data['code'];
                    $model->name = $data['name'];
                    $model->description = $data['description'];
                    $model->save();
                } catch (\Throwable $th) {
                    $data['error'] = $th->getMessage();
                    $list_error[] = $data;
                }
            }
        });
        $time_now = Carbon::now()->timestamp;
        $column_export = $this->columnExportError();
        Excel::store(new ErrorExport($list_error, $column_export), 'public/media/' . 'dich_vu_loi_' . $time_now . '.xlsx');
        $fileUrl = url('storage/media/' . 'dich_vu_loi_' . $time_now . '.xlsx');
        return response()->json([
            'success' => true,
            'message' => trans('backend::servicetype.message.import success'),
            'total' => count($datas),
            'fileUrl' => $fileUrl,
            'total_success' => (count($datas) - count($list_error))
        ]);
    }

    public function validateData($servicetype)
    {
        if (!$servicetype['code']) {
            return trans('backend::servicetype.label.code') . trans('backend::mon.error.required');
        }
        return null;
    }

    public function columnExportError()
    {
        return [
            [
                'col_name' => 'code',
                'name' => trans('backend::servicetype.label.code'),
            ],
            [
                'col_name' => 'name',
                'name' => trans('backend::servicetype.label.name'),
            ],
            [
                'col_name' => 'description',
                'name' => trans('backend::servicetype.label.description'),
            ]
        ];
    }
}
