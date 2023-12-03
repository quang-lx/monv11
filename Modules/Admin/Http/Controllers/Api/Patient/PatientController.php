<?php

namespace Modules\Admin\Http\Controllers\Api\Patient;

use App\Exports\ErrorExport;
use App\Exports\PatientExport;
use App\Imports\ImportPatient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\Patient;
use Modules\Admin\Http\Requests\Patient\CreatePatientRequest;
use Modules\Admin\Http\Requests\Patient\UpdatePatientRequest;
use Modules\Admin\Repositories\PatientRepository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Admin\Http\Requests\Excel\ExcelUploadRequest;
use Modules\Admin\Transformers\PatientHasServiceTransformer;
use Modules\Admin\Transformers\PatientTransformer;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;
use Illuminate\Support\Facades\Log;

class PatientController extends ApiController
{
    /**
     * @var PatientRepository
     */
    private $patientRepository;

    public function __construct(Authentication $auth, PatientRepository $patient)
    {
        parent::__construct($auth);

        $this->patientRepository = $patient;
    }


    public function index(Request $request)
    {
        return PatientTransformer::collection($this->patientRepository->serverPagingFor($request));
    }


    public function all(Request $request)
    {
        return PatientTransformer::collection($this->patientRepository->newQueryBuilder()->get());
    }


    public function store(CreatePatientRequest $request)
    {
        return $this->patientRepository->create($request->all());
    }


    public function find(Patient $patient)
    {
        return new PatientTransformer($patient);
    }

    public function update(Patient $patient, UpdatePatientRequest $request)
    {
        return $this->patientRepository->update($patient, $request->all());
    }

    public function destroy(Patient $patient)
    {
        $this->patientRepository->destroy($patient);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::patient.message.delete success'),
        ]);
    }

    public function getPatientHasService(Request $request)
    {
        return PatientHasServiceTransformer::collection($this->patientRepository->getPatientHasService($request));
    }

    public function exports(Request $request)
    {
        $time_now = Carbon::now()->timestamp;
        Excel::store(new PatientExport($request), '/public/media/' . 'patient_' . $time_now . '.xlsx');
        $fileUrl = url('storage/media/' . 'patient_' . $time_now . '.xlsx');
        return response()->json(['success' => true, 'fileUrl' => $fileUrl]);
    }

    public function imports(ExcelUploadRequest $request)
    {
        $import = new ImportPatient();
        Excel::import($import, $request->file('file'));
        $data_import = $import->getDataImport();
        $list_error = [];

        foreach ($data_import as $key => $data) {
            try {
                $message_error = $this->validateData($data);
                if ($message_error) {
                    throw new \Exception($message_error);
                }
                $model = new Patient();
                $model->create($data);
            } catch (\Throwable $th) {
                $data['error'] = $th->getMessage();
                $list_error[] = $data;
            }
        }
        $column_export = $this->columnExportError();
        $time_now = Carbon::now()->timestamp;
        Excel::store(new ErrorExport($list_error, $column_export), 'public/media/' . 'patient_error_' . $time_now . '.xlsx');
        $fileUrl = url('storage/media/' . 'patient_error_' . $time_now . '.xlsx');
        return response()->json([
            'success' => true,
            'message' => trans('backend::patient.message.import success'),
            'total' => count($data_import),
            'fileUrl' => $fileUrl,
            'total_success' => (count($data_import) - count($list_error))
        ]);
    }

    public function validateData($data)
    {
        if (!$data['name']) {
            return trans('backend::patient.label.name') . trans('backend::mon.error.required');
        }
        if (!$data['sex']) {
            return trans('backend::patient.label.sex') . trans('backend::mon.error.required');
        }
        if (!$data['birthday']) {
            return trans('backend::patient.label.birthday') . trans('backend::mon.error.required');
        }
        if (!$data['phone']) {
            return trans('backend::patient.label.phone') . trans('backend::mon.error.required');
        }
        return null;
    }

    public function columnExportError()
    {
        return [
            [
                'col_name' => 'name',
                'name' => trans('backend::patient.label.name'),
            ],
            [
                'col_name' => 'sex',
                'name' => trans('backend::patient.label.sex'),
            ],
            [
                'col_name' => 'birthday',
                'name' => trans('backend::patient.label.birthday'),
            ],
            [
                'col_name' => 'phone',
                'name' => trans('backend::patient.label.phone'),
            ],
            [
                'col_name' => 'email',
                'name' => trans('backend::patient.label.email'),
            ],
            [
                'col_name' => 'job',
                'name' => trans('backend::patient.label.job'),
            ],
            [
                'col_name' => 'papers',
                'name' => trans('backend::patient.label.papers'),
            ],

            [
                'col_name' => 'dependant',
                'name' => trans('backend::patient.label.dependant'),
            ],

            [
                'col_name' => 'phone_dependant',
                'name' => trans('backend::patient.label.phone_dependant'),
            ],
            [
                'col_name' => 'error',
                'name' => trans('backend::mon.error.Title'),
            ]
        ];
    }

    public function changeStatus(Request $request)
    {
        return $this->patientRepository->changeStatus($request->all());
    }


}
