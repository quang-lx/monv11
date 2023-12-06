<?php

namespace Modules\Mon\Http\Middleware;

use Closure;
use Modules\Mon\Auth\Contracts\Authentication;
use Illuminate\Support\Facades\Route;
use Modules\Mon\Entities\User;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        /** @var Authentication $auth */
        $auth = app(Authentication::class);
        if (!$auth->check()) {
            return redirect()->guest(route('admin.login'));
        }
        if (!$auth->user()->hasRole('cms_login')) {
            $auth->logout();
            return redirect()->guest(route('admin.login'))->withErrors(['username' => 'Vui lòng đăng nhâp bằng tài khoản quản trị!']);
        }
        $routeName = Route::currentRouteName();

        if ($auth->user()->need_change_password == User::NEED_CHANGE_PASSWORD && $routeName !== 'admin.need_change_password' ) {
            return redirect()->route('admin.need_change_password');       
        }

        return $next($request);
    }
}
