<?php

namespace Modules\Admin\Http\Controllers\Api\Disease;

use App\Exports\DiseaseErrorExport;
use App\Exports\DiseaseExport;
use App\Imports\ImportDisease;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\Disease;
use Modules\Admin\Http\Requests\Disease\CreateDiseaseRequest;
use Modules\Admin\Http\Requests\Disease\UpdateDiseaseRequest;
use Modules\Admin\Repositories\DiseaseRepository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Admin\Http\Requests\Excel\ExcelUploadRequest;
use Modules\Admin\Transformers\DiseaseTransformer;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;
use Illuminate\Support\Facades\Log;

class DiseaseController extends ApiController
{
    /**
     * @var DiseaseRepository
     */
    private $diseaseRepository;

    public function __construct(Authentication $auth, DiseaseRepository $disease)
    {
        parent::__construct($auth);

        $this->diseaseRepository = $disease;
    }


    public function index(Request $request)
    {
        return DiseaseTransformer::collection($this->diseaseRepository->serverPagingFor($request));
    }


    public function all(Request $request)
    {
        return DiseaseTransformer::collection($this->diseaseRepository->newQueryBuilder()->get());
    }


    public function store(CreateDiseaseRequest $request)
    {
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $this->diseaseRepository->create($data);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::disease.message.create success'),
        ]);
    }


    public function find(Disease $disease)
    {
        return new  DiseaseTransformer($disease);
    }

    public function update(Disease $disease, UpdateDiseaseRequest $request)
    {
        $data = $request->all();
        unset($data['created_by']);
        $this->diseaseRepository->update($disease, $data);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::disease.message.update success'),
        ]);
    }

    public function destroy(Disease $disease)
    {
        $this->diseaseRepository->destroy($disease);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::disease.message.delete success'),
        ]);
    }

    public function exports(Request $request)
    {
        $time_now = Carbon::now()->timestamp;
        Excel::store(new DiseaseExport($request), '/public/media/' . 'disease_' . $time_now . '.xlsx');
        $fileUrl = url('storage/media/' . 'disease_' . $time_now . '.xlsx');
        return response()->json(['success' => true, 'fileUrl' => $fileUrl]);
    }

    public function imports(ExcelUploadRequest $request)
    {
        $import = new ImportDisease();
        Excel::import($import, $request->file('file'));
        $data_disease = $import->getDataImport();
        $list_error = [];

        DB::transaction(function () use ($request, &$data_disease, &$list_error) {

            foreach ($data_disease as $key => $disease) {
                try {
                    $message_error = $this->validateData($disease);
                    if ($message_error) {
                        throw new \Exception($message_error);
                    }
                    $disease_model = new Disease();
                    $disease_model->code = $disease['code'];
                    $disease_model->name = $disease['name'];
                    $disease_model->describe = $disease['describe'];
                    $disease_model->created_by = Auth::user()->id;
                    $disease_model->save();
                } catch (\Throwable $th) {
                    Log::info($th->getMessage());
                    $disease['error'] = $th->getMessage();
                    $list_error[] = $disease;
                }
            }
        });
        $time_now = Carbon::now()->timestamp;
        Excel::store(new DiseaseErrorExport($list_error), 'public/media/' . 'disease_error_' . $time_now . '.xlsx');
        $fileUrl = url('storage/media/' . 'disease_error_' . $time_now . '.xlsx');
        return response()->json([
            'success' => true,
            'message' => trans('backend::disease.message.import success'),
            'total' => count($data_disease),
            'fileUrl' => $fileUrl,
            'total_success' => (count($data_disease) - count($list_error))
        ]);
    }

    public function validateData($disease){
        if (!$disease['code']) {
           return trans('backend::disease.label.code').trans('backend::mon.error.required');
        }
        return null;
    }
}
