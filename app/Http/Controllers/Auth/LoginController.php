<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;
use App\User;

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
    protected $redirectTo;

    public function redirectTo()
    {
        switch(Auth::user()->role){
            case 1:
            $this->redirectTo = '/admin';
            return $this->redirectTo;
                break;
            case 2:
                    $this->redirectTo = '/manager';
                return $this->redirectTo;
                break;
            case 3:
                $this->redirectTo = '/customer';
                return $this->redirectTo;
                break;
            default:
                $this->redirectTo = '/login';
                return $this->redirectTo;
        }
         
        // return $next($request);
    } 


    public function adminLogin()
    {
        return view('auth.admin-login');
    }

    public function adminLogedin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        $is_admin = user::where([['email', $request['email']],['role', 1]])->count();
        if($is_admin == 1){
            if(auth()->attempt(array('email' => $request['email'], 'password' => $request['password'])))
            {
                return redirect()->route('admin');
                
            }else{ 
                return redirect('admin/login')
                    ->with('message','These credentials do not match our records.');
            }
        }else{
            return redirect('admin/login')
                    ->with('message','You are not admin.');
        }
            
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }
}
