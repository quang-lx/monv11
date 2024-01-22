<?php

namespace Modules\Admin\Http\Controllers\Api\Department;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Transformers\DepartmentTransformer;
use Modules\Mon\Entities\Department;
use Modules\Admin\Http\Requests\Department\CreateDepartmentRequest;
use Modules\Admin\Http\Requests\Department\UpdateDepartmentRequest;
use Modules\Admin\Repositories\DepartmentRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Entities\User;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class DepartmentController extends ApiController
{
    /**
     * @var DepartmentRepository
     */
    private $departmentRepository;

    public function __construct(Authentication $auth, DepartmentRepository $department)
    {
        parent::__construct($auth);

        $this->departmentRepository = $department;
    }

    public function countNotAssign(Request $request) {
        $not_assign =  User::query()->whereHas('department', function ($query) {
            $query->where('not_assign', 1);
        })->count();
        $all =  User::query()->count();
        return [
          'user_not_assign' => $not_assign,
          'user_assign' => $all - $not_assign
        ];
     }
    public function tree(Request $request)
    {
        return $this->departmentRepository->getAllTree(null, $request);
    }
    public function getAllHierarchy(Request $request)
    {
        return $this->departmentRepository->getAllHierarchy();
    }
    public function index(Request $request)
    {
        return DepartmentTransformer::collection($this->departmentRepository->serverPagingFor($request));
    }


    public function all(Request $request)
    {
        return DepartmentTransformer::collection($this->departmentRepository->newQueryBuilder()->get());
    }


    public function store(CreateDepartmentRequest $request)
    {
        $this->departmentRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::department.message.create success'),
        ]);
    }


    public function find(Department $department)
    {
        return new  DepartmentTransformer($department);
    }

    public function update(Department $department, UpdateDepartmentRequest $request)
    {
        $this->departmentRepository->update($department, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::department.message.update success'),
        ]);
    }

    public function destroy(Department $department)
    {
        $this->departmentRepository->destroy($department);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::department.message.delete success'),
        ]);
    }
}
