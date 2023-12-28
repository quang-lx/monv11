<?php

namespace Modules\Admin\Http\Controllers\Api\ExaminationIndex;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Transformers\ExaminationIndexTransformer;
use Modules\Mon\Entities\ExaminationIndex;
use Modules\Admin\Http\Requests\ExaminationIndex\CreateExaminationIndexRequest;
use Modules\Admin\Http\Requests\ExaminationIndex\UpdateExaminationIndexRequest;
use Modules\Admin\Repositories\ExaminationIndexRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class ExaminationIndexController extends ApiController
{
    /**
     * @var ExaminationIndexRepository
     */
    private $examinationindexRepository;

    public function __construct(Authentication $auth, ExaminationIndexRepository $examinationindex)
    {
        parent::__construct($auth);

        $this->examinationindexRepository = $examinationindex;
    }


    public function index(Request $request)
    {
        return ExaminationIndexTransformer::collection($this->examinationindexRepository->serverPagingFor($request));
    }


    public function all(Request $request)
    {
        return ExaminationIndexTransformer::collection($this->examinationindexRepository->newQueryBuilder()->get());
    }


    public function store(CreateExaminationIndexRequest $request)
    {
        $this->examinationindexRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::examinationindex.message.create success'),
        ]);
    }


    public function find(ExaminationIndex $examinationindex)
    {
        return new  ExaminationIndexFullTransformer($examinationindex);
    }

    public function update(ExaminationIndex $examinationindex, UpdateExaminationIndexRequest $request)
    {
        $this->examinationindexRepository->update($examinationindex, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::examinationindex.message.update success'),
        ]);
    }

    public function destroy(ExaminationIndex $examinationindex)
    {
        $this->examinationindexRepository->destroy($examinationindex);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::examinationindex.message.delete success'),
        ]);
    }
}
