<?php

namespace Modules\Mon\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Mon\Auth\Contracts\Authentication;
use Modules\Mon\Http\Controllers\WebController;
use Modules\Mon\Http\Requests\User\ChangePasswordRequest;

class UserController extends WebController
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    public function __construct(Authentication $auth)
    {
        parent::__construct($auth);
        $this->middleware('auth');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->need_change_password = 2;
        $user->save();
        Auth::logout();
        return redirect()->route('admin.login')->with('success', 'Đổi mật khẩu thành công');;
    }

    
}
