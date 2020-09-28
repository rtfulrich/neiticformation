<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('auth/login');
    }

    /**
      * Handle an authentication attempt.
      *
      * @param  \Illuminate\Http\Request $request
      *
      * @return Response
      */
    public function authenticate(Request $request)
    {
        $login = '';
        // if (preg_match('/@/', $request->login)) $login = 'email';
        if (filter_var($request->login, FILTER_VALIDATE_EMAIL)) $login = "email";
        else $login = 'username';
        
        $credentials = [$login => $request->login, 'password' => $request->password];

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('/home');
        } else return redirect('/login')->with('error', 'Identifiant ou mot de passe incorrect !');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }


}
