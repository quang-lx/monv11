<?php

namespace Modules\Admin\Http\Controllers\Api\Patient;

use App\Exports\PatientExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\Patient;
use Modules\Admin\Http\Requests\Patient\CreatePatientRequest;
use Modules\Admin\Http\Requests\Patient\UpdatePatientRequest;
use Modules\Admin\Repositories\PatientRepository;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Admin\Transformers\PatientHasServiceTransformer;
use Modules\Admin\Transformers\PatientTransformer;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

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
        $this->patientRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::patient.message.create success'),
        ]);
    }


    public function find(Patient $patient)
    {
        return new  PatientTransformer($patient);
    }

    public function update(Patient $patient, UpdatePatientRequest $request)
    {
        $this->patientRepository->update($patient, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::patient.message.update success'),
        ]);
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

}
