<?php

namespace Modules\Admin\Http\Controllers\Api\ExaminationService;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Transformers\ExaminationServiceListTransformer;
use Modules\Admin\Transformers\ExaminationServiceTransformer;
use Modules\Mon\Entities\ExaminationService;
use Modules\Admin\Http\Requests\ExaminationService\CreateExaminationServiceRequest;
use Modules\Admin\Http\Requests\ExaminationService\UpdateExaminationServiceRequest;
use Modules\Admin\Repositories\ExaminationServiceRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class ExaminationServiceController extends ApiController
{
    /**
     * @var ExaminationServiceRepository
     */
    private $examinationserviceRepository;

    public function __construct(Authentication $auth, ExaminationServiceRepository $examinationservice)
    {
        parent::__construct($auth);

        $this->examinationserviceRepository = $examinationservice;
    }


    public function index(Request $request)
    {
        return ExaminationServiceListTransformer::collection($this->examinationserviceRepository->serverPagingFor($request));
    }


    public function all(Request $request)
    {
        return ExaminationServiceTransformer::collection($this->examinationserviceRepository->newQueryBuilder()->get());
    }


    public function store(CreateExaminationServiceRequest $request)
    {
        $this->examinationserviceRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::examinationservice.message.create success'),
        ]);
    }


    public function find(ExaminationService $examinationservice)
    {
        return new  ExaminationServiceFullTransformer($examinationservice);
    }

    public function update(ExaminationService $examinationservice, UpdateExaminationServiceRequest $request)
    {
        $this->examinationserviceRepository->update($examinationservice, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::examinationservice.message.update success'),
        ]);
    }

    public function destroy(ExaminationService $examinationservice)
    {
        $this->examinationserviceRepository->destroy($examinationservice);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::examinationservice.message.delete success'),
        ]);
    }
}
