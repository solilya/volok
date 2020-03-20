<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
   
    
    public function username()
	{
    	return 'login';
	}
	
	protected function redirectTo()
	{
		
    	if (auth()->user()->roles->contains('role','маркетинг')) { #маркетинг
        	return '/';
    	}
    	

    	if (auth()->user()->roles->contains('id','60')) {   #технический отдел
          	return '/list_teh_ticket';
    	}
    
    	if (auth()->user()->login=='admin') {
        	return '/auth/print_menu';
    	}
    	return '/home';
	}

    
}
