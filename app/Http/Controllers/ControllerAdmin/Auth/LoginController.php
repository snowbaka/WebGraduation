<?php

namespace App\Http\Controllers\ControllerAdmin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('guest')->except('logout');
    }



    public function login()
    {
        return view('admin.auth.login');
    }


    public function postLogin(LoginRequest $request)
    {
        $user = $request->except('_token');
        $dataUser = User::where('email', $request->email)->first();
        if (!$dataUser) {
            return redirect()->back()->with('danger', 'Username or password incorrect');
        }

        if ($dataUser->level == 0 ) {
            return redirect()->route('admin.login')->with('danger', 'You can not access this page');
        }

        if ($dataUser->status == User::STATUS_LOCKED) {
            return redirect()->back()->with('danger', 'Your account is locked please contact your administrator.');
        }

        if (Auth::attempt($user)) {
            return redirect()->route('admin.home');
        } else {
            return redirect()->back()->with('danger', 'Username or password incorrect');
        }
    }

    /*
     * logout
     */
    public function logoutUser()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
