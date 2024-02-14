<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('adminPostLogout');
    }

    /**
     * Display Login password form
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->intended(route('admin.get.dashboard'));
        } else {
            return view('admin.auth.login');
        }
    }

    public function postLogin(LoginRequest $request)
    {
        $postData = $request->all();
        try {
            $remember_me  = (!empty($request->remember_me)) ? TRUE : FALSE;

            // create our user data for the authentication
            $userdata = array(
                'email' => $postData['email'],
                'password' => $postData['password'],
                'status' => 1,
                //'user_type' => "SuperAdmin",
            );
            // attempt to do the login

            if (Auth::guard('admin')->attempt($userdata, $remember_me)) {
                return redirect()->route('admin.get.dashboard');
            } else {
                return back()->with('error', 'Email address or password is not valid.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong.');
        }
    }
    public function adminPostLogout()
    {
        Auth::guard('admin')->logout();
        return redirect(route('admin.get.login'));
    }
}
