<?php

namespace Modules\Admin\Http\Controllers\Api\PatientExamination;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\PatientExamination;
use Modules\Admin\Http\Requests\PatientExamination\CreatePatientExaminationRequest;
use Modules\Admin\Http\Requests\PatientExamination\UpdatePatientExaminationRequest;
use Modules\Admin\Repositories\PatientExaminationRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;
use Modules\Admin\Transformers\PatientExaminationTransformer;

class PatientExaminationController extends ApiController
{
    /**
     * @var PatientExaminationRepository
     */
    private $patientexaminationRepository;

    public function __construct(Authentication $auth, PatientExaminationRepository $patientexamination)
    {
        parent::__construct($auth);

        $this->patientexaminationRepository = $patientexamination;
    }


    public function index(Request $request)
    {
        return PatientExaminationTransformer::collection($this->patientexaminationRepository->serverPagingFor($request));
    }


    public function all(Request $request)
    {
        return PatientExaminationTransformer::collection($this->patientexaminationRepository->newQueryBuilder()->get());
    }


    public function store(CreatePatientExaminationRequest $request)
    {
        $this->patientexaminationRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::patientexamination.message.create success'),
        ]);
    }


    public function find(PatientExamination $patientexamination)
    {
        return new  PatientExaminationTransformer($patientexamination);
    }

    public function update(PatientExamination $patientexamination, UpdatePatientExaminationRequest $request)
    {
        $this->patientexaminationRepository->update($patientexamination, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::patientexamination.message.update success'),
        ]);
    }

    public function destroy(PatientExamination $patientexamination)
    {
        $this->patientexaminationRepository->destroy($patientexamination);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::patientexamination.message.delete success'),
        ]);
    }
}
