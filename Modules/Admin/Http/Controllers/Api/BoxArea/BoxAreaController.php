<?php

namespace Modules\Admin\Http\Controllers\Api\BoxArea;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Transformers\BoxAreaTransformer;
use Modules\Mon\Entities\Box;
use Modules\Mon\Entities\BoxArea;
use Modules\Admin\Http\Requests\BoxArea\CreateBoxAreaRequest;
use Modules\Admin\Http\Requests\BoxArea\UpdateBoxAreaRequest;
use Modules\Admin\Repositories\BoxAreaRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Entities\User;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class BoxAreaController extends ApiController
{
    /**
     * @var BoxAreaRepository
     */
    private $boxareaRepository;

    public function __construct(Authentication $auth, BoxAreaRepository $boxarea)
    {
        parent::__construct($auth);

        $this->boxareaRepository = $boxarea;
    }


    public function index(Request $request)
    {
        return BoxAreaTransformer::collection($this->boxareaRepository->serverPagingFor($request));
    }


    public function all(Request $request)
    {
        return BoxAreaTransformer::collection($this->boxareaRepository->newQueryBuilder()->get());
    }


    public function store(CreateBoxAreaRequest $request)
    {
        $this->boxareaRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::box_area.message.create success'),
        ]);
    }


    public function find(BoxArea $boxarea)
    {
        return new  BoxAreaTransformer($boxarea);
    }

    public function update(BoxArea $boxarea, UpdateBoxAreaRequest $request)
    {
        $this->boxareaRepository->update($boxarea, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::box_area.message.update success'),
        ]);
    }

    public function destroy(BoxArea $boxarea)
    {
        $this->boxareaRepository->destroy($boxarea);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::box_area.message.delete success'),
        ]);
    }
    public function count(Request $request) {
        $not_assign =  Box::query()->whereHas('area', function ($query) {
            $query->where('not_assign', 1);
        })->count();
        $assign =   Box::query()->whereHas('area', function ($query) {
            $query->where('not_assign', 0);
        })->count();;
        return [
            'not_assign' => $not_assign,
            'assign' => $assign
        ];
    }
    public function tree(Request $request)
    {
        return $this->boxareaRepository->getAllTree(null, $request);
    }
    public function getNotAssignTree(Request $request)
    {
        return $this->boxareaRepository->getNotAssignTree(null, $request);
    }
    public function getAllHierarchy(Request $request)
    {
        return $this->boxareaRepository->getAllHierarchy();
    }
}
