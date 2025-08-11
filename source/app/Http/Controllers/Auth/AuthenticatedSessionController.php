<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{

//    login for admin
    public function adminloginform(){
        if (Auth::check() && (Auth::user()->type == 1 || Auth::user()->type == 2)) {
            return redirect()->route('superAdminDashboardShow');
        }else{
            return view('auth.admin_login');
        }
    }
    public function adminlogin(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Check the user role
            if (Auth::user()->type == 1 && Auth::user()->status == 1 || Auth::user()->type == 2 ) {
                return redirect()->route('superAdminDashboardShow')->with('success', 'Login successful');
            } else {
                // If the user is authenticated but not an admin, log out and redirect to login with an error
                Auth::logout();
                return redirect()->route('adminlogin')->with('error', 'You do not have permission to access this page!');
            }
        } else {
            // If authentication fails, redirect back to login with an error
            return redirect()->route('adminlogin')->with('error', 'Wrong credentials');
        }
    }



    /**
     * Display the login view.
     */
//    public function create(): View
//    {
//        return view('auth.login');
//    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }


//    public function customLogin(Request $request){
//
//        $input = $request->all();
//        $this->validate($request, [
//            'email' => 'required|email',
//            'password' => 'required',
//        ]);
//
//        // check if the given user exists in db
//        if(Auth::attempt(['email'=> $input['email'], 'password'=> $input['password']])){
//            // check the user role
//            if(Auth::user()->type == 0){
//                return redirect()->route('dashboard');
//            }
//            else{
//                return redirect()->route('superAdminDashboardShow');
//            }
//        }
//        else{
//            return redirect()->route('login')->with('error', "Wrong credentials");
//        }
//
//    }

}
