<?php

namespace Modules\Admin\Http\Controllers\Api\Auth;

use App\Exports\UsersErrorExport;
use App\Exports\UsersExport;
use App\Imports\ImportUsers;
use Modules\Mon\Entities\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Admin\Http\Requests\UploadAvatarRequest;
use Modules\Admin\Http\Requests\User\ChangePasswordRequest;
use Modules\Admin\Http\Requests\User\CreateUserRequest;
use Modules\Admin\Http\Requests\Excel\ExcelUploadRequest;
use Modules\Admin\Http\Requests\User\UpdateUserRequest;
use Modules\Admin\Transformers\Auth\UserFullTransformer;
use Modules\Admin\Transformers\Auth\UserPermissionsTransformer;
use Modules\Admin\Transformers\Auth\UserTransformer;

use Modules\Media\Services\FileService;
use Modules\Media\Transformers\MediaTransformer;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Repositories\ProfileRepository;
use Modules\Mon\Repositories\UserRepository;
use Modules\Mon\Auth\Contracts\Authentication;

class UserController extends ApiController
{
    /**
     * @var FileService
     */
    private $fileService;
    /**
     * @var UserRepository
     */
    protected $userRepository;
    /**
     * @var ProfileRepository
     */
    protected $profileRepository;
    public function __construct(
        Authentication $auth,
        UserRepository $userRepository,
        ProfileRepository $profileRepository,
        FileService $fileService
    ) {
        parent::__construct($auth);
        $this->userRepository = $userRepository;
        $this->profileRepository = $profileRepository;
        $this->fileService = $fileService;


    }

    public function uploadAvatar(UploadAvatarRequest $request)
    {
        $savedFile = $this->fileService->store($request->file('file'), $request->get('parent_id')? : 0);

        if (is_string($savedFile)) {
            return response()->json([
                'error' => $savedFile,
            ], 409);
        }

        $user = $this->auth->user();
        $user->avatar_url = $savedFile->path_string;
        $user->save();
        return new MediaTransformer($savedFile);
    }

    public function index(Request $request)
    {
        return UserTransformer::collection($this->userRepository->serverPagingFor($request));
    }

    public function store(CreateUserRequest $request)
    {

        $data = $request->all();


        $data['sms_verified_at'] = now();
        $data['finish_reg'] = 1;
        $data['password'] = env('DEFAULT_PASSWORD', '123456aA@');

        $user = $this->userRepository->createWithRoles($data, $request->get('roles'));

        return response()->json([
            'errors' => false,
            'message' => trans('backend::user.message.create success'),
        ]);
    }

    public function find(User $user)
    {
        return new UserFullTransformer($user);
    }

    public function profile()
    {
        return new UserFullTransformer(auth()->user());
    }

    public function update(User $user, UpdateUserRequest $request)
    {
        $data = $request->all();

        $this->userRepository->updateAndSyncRoles($user, $data, $request->get('roles'));

        return response()->json([
            'errors' => false,
            'message' => trans('backend::user.message.update success'),
        ]);
    }

    public function destroy(User $user)
    {
        $currentUser = $this->auth->user();
        if ($currentUser->username == $user->username) {
            return response()->json([
                'errors' => true,
                'message' => trans('backend::user.message.not allow self delete'),
            ]);
        }

        $this->userRepository->destroy($user);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::user.message.delete success'),
        ]);
    }
    public function hasPermissions(Request $request)
    {
        $user = $this->auth->user();

        return UserPermissionsTransformer::collection($user->getAllPermissions());
    }
    public function changePassword(User $user, ChangePasswordRequest $request)
    {
        $data = $request->all();

        $this->userRepository->changePassword($user, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::user.message.change password success'),
        ]);
    }
    public function resetPassword(User $user, Request $request)
    {
        $data = $request->all();

        $this->userRepository->resetPassword($user, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::user.message.reset password success'),
        ]);
    }

    public function exports(Request $request)
    {
        $time_now = Carbon::now()->timestamp;
        $file_name = 'users_' . $time_now . '.xlsx';
        Excel::store(new UsersExport($request), ('/public/media/'. $file_name));
        $fileUrl = url('storage/media/' . $file_name);
        return response()->json(['success' => true, 'fileUrl' => $fileUrl]);
    }

    public function imports(ExcelUploadRequest $request)
    {
        $import = new ImportUsers();
        Excel::import($import, $request->file('file'));
        $data_user = $import->getDataImport();
        $list_error = [];

        DB::transaction(function () use ($request, &$data_user, &$list_error) {

            foreach ($data_user as $key => $user) {
                try {
                    if (User::where('username', $user['username'])->first()) {
                        throw new \Exception('Custom exception message');
                    }
                    $user_model = new User();
                    $user_model->name = $user['name'];
                    $user_model->email = $user['email'];
                    $user_model->phone = $user['phone'];
                    $user_model->department_id = $user['department_id'];
                    $user_model->birth_day = $user['birth_day'];
                    $user_model->identification = $user['identification'];
                    $user_model->active_at = $user['active_at'];
                    $user_model->expired_at = $user['expired_at'];
                    $user_model->username = $user['username'];
                    $user_model->password = Hash::make('123456aA@');
                    $user_model->save();
                } catch (\Throwable $th) {
                    $list_error[] = $user;
                }
            }
        });
        $time_now = Carbon::now()->timestamp;
        $file_name = 'users_error_' . $time_now . '.xlsx';
        Excel::store(new UsersErrorExport($list_error),   ('/public/media/'. $file_name));
        $fileUrl = url('storage/media/' . $file_name);
        return response()->json([
            'success' => true,
            'message' => 'Tải lên danh sách user thành công',
            'total' => count($data_user),
            'fileUrl' => $fileUrl,
            'total_success' => count($data_user) - count($list_error)
        ]);
    }
}
