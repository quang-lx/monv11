<?php

namespace Modules\Mon\Http\Controllers\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Mon\Auth\Contracts\Authentication;
use Modules\Mon\Http\Controllers\WebController;
use Modules\Mon\Repositories\UserRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;


class LoginController extends WebController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @param Authentication $authentication
     */
    public function __construct(Authentication $authentication)
    {
        parent::__construct($authentication);
        $this->middleware('guest')->except('logout');
    }
    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }
    public function google()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        $gUser = Socialite::driver('google')->user();
        $user = $this->user->findByAttributes(['google_id' => $gUser->id]);
        if (!$user) {
            $data = [
                'facebook_id' => $gUser->getId(),
                'name' => $gUser->getName(),
                'email' => $gUser->getEmail(),
                'password' => \Hash::make(str_random(12))
            ];
            $user = $this->user->create($data);
            event(new Registered($user));
        }
        $this->guard()->login($user);
        app(UserRepository::class)->update($user, ['last_login' => date('Y-m-d H:i:s')]);
        return redirect()->intended($this->redirectPath());
    }

    public function facebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookCallback()
    {
        $fbUser = Socialite::driver('facebook')->user();
        $user = $this->user->findByAttributes(['facebook_id' => $fbUser->id]);
        if (!$user) {
            $email = $fbUser->getEmail();
            if (!$email) {
                $email = $fbUser->getId() . '@webgiasu.net';
            }
            $data = [
                'facebook_id' => $fbUser->getId(),
                'name' => $fbUser->getName(),
                'email' => $email,
                'gender' => $fbUser->getGender(),
                'password' => Hash::make(str_random(12))
            ];
            $user = $this->user->create($data);
            event(new Registered($user));
        }
        $this->guard()->login($user);
        app(UserRepository::class)->update($user, ['last_login' => date('Y-m-d H:i:s')]);
        return redirect()->intended($this->redirectPath());
    }
    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $token = auth('api')->login($user);

        $request->session()->put('jwt_token', $token);
        app(UserRepository::class)->update($user, ['last_login' => date('Y-m-d H:i:s')]);

        return redirect()->intended($this->redirectPath());
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            return response()->json(['msg' => 'Logout successful!']);
        }
        $previousPath = url()->previous();

        if (in_array('admin', explode('/', $previousPath))) {
            return redirect($previousPath)->withSuccess(__('Logout successful!'));
        }
        return redirect()->route('home')->withSuccess(__('Logout successful!'));
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return $this->view('auth.login');
    }
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAdminLoginForm()
    {
        return view('backend::login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $user = User::where('username', $request->input('username'))->first();
        if (!$user) {
            return back()->withErrors(['username' => 'Tên người dùng hoặc mật khẩu không chính xác.'])->withInput();
        }
        $currentDateTime = Carbon::now();
        if ($user->retry_time && Carbon::parse($user->retry_time)->gt($currentDateTime)) {
            return back()->withErrors(['username' => 'Tài khoản tạm thời bị khoá do nhập sai quá 5 lần. Vui lòng thử lại sau 15 phút.'])->withInput();
        }

        if (auth()->attempt($credentials)) {
            $user->enter_wrong_password = 0;
            $user->retry_time = null;
            $user->save();
            return $this->authenticated($request, auth()->user())
                ?: redirect()->intended($this->redirectTo);
        }

        if ($user->enter_wrong_password == 5) {
            $extendedTime = $currentDateTime->addMinutes(15);
            $user->retry_time = $extendedTime;
            $user->enter_wrong_password = 0;
        } else {
            $user->enter_wrong_password = $user->enter_wrong_password + 1;
        }
        $user->save();
        return back()->withErrors(['username' => 'Tên người dùng hoặc mật khẩu không chính xác.'])->withInput();

    }
}
