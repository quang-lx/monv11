<?php

namespace Modules\Admin\Http\Controllers\Api\Box;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Transformers\BoxTransformer;
use Modules\Mon\Entities\Box;
use Modules\Admin\Http\Requests\Box\CreateBoxRequest;
use Modules\Admin\Http\Requests\Box\UpdateBoxRequest;
use Modules\Admin\Repositories\BoxRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class BoxController extends ApiController
{
    /**
     * @var BoxRepository
     */
    private $boxRepository;

    public function __construct(Authentication $auth, BoxRepository $box)
    {
        parent::__construct($auth);

        $this->boxRepository = $box;
    }


    public function index(Request $request)
    {
        return BoxTransformer::collection($this->boxRepository->serverPagingFor($request));
    }


    public function all(Request $request)
    {
        return BoxTransformer::collection($this->boxRepository->newQueryBuilder()->get());
    }


    public function store(CreateBoxRequest $request)
    {
        $this->boxRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::box.message.create success'),
        ]);
    }


    public function find(Box $box)
    {
        return new  BoxTransformer($box);
    }

    public function update(Box $box, UpdateBoxRequest $request)
    {
        $this->boxRepository->update($box, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::box.message.update success'),
        ]);
    }

    public function destroy(Box $box)
    {
        $this->boxRepository->destroy($box);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::box.message.delete success'),
        ]);
    }
}
