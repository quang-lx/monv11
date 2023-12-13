<?php

namespace Modules\Admin\Http\Controllers\Api\ExaminationHealth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Transformers\ExaminationHealthTransformer;
use Modules\Mon\Entities\ExaminationHealth;
use Modules\Admin\Http\Requests\ExaminationHealth\CreateExaminationHealthRequest;
use Modules\Admin\Http\Requests\ExaminationHealth\UpdateExaminationHealthRequest;
use Modules\Admin\Repositories\ExaminationHealthRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class ExaminationHealthController extends ApiController
{
    /**
     * @var ExaminationHealthRepository
     */
    private $examinationhealthRepository;

    public function __construct(Authentication $auth, ExaminationHealthRepository $examinationhealth)
    {
        parent::__construct($auth);

        $this->examinationhealthRepository = $examinationhealth;
    }


    public function index(Request $request)
    {
        return ExaminationHealthTransformer::collection($this->examinationhealthRepository->serverPagingFor($request));
    }


    public function all(Request $request)
    {
        return ExaminationHealthTransformer::collection($this->examinationhealthRepository->newQueryBuilder()->get());
    }


    public function store(CreateExaminationHealthRequest $request)
    {
        $model = $this->examinationhealthRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'id' => $model->id,
            'message' => trans('backend::health.message.create success'),
        ]);
    }


    public function find(ExaminationHealth $examinationhealth)
    {
        return new  ExaminationHealthTransformer($examinationhealth);
    }

    public function update(ExaminationHealth $examinationhealth, UpdateExaminationHealthRequest $request)
    {
        $examinationhealth = $this->examinationhealthRepository->update($examinationhealth, $request->all());

        return response()->json([
            'errors' => false,
            'id' => $examinationhealth->id,
            'message' => trans('backend::health.message.update success'),
        ]);
    }

    public function destroy(ExaminationHealth $examinationhealth)
    {
        $this->examinationhealthRepository->destroy($examinationhealth);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::health.message.delete success'),
        ]);
    }
}
