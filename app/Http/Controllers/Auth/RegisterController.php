<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

	
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'login' => ['required', 'string', 'max:255', 'unique:users', 'regex:/^[a-zA-Z0-9_]+$/'],
            'password' => ['required', 'string'],
            'role'=>['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'login' => $data['login'],
            'password' => Hash::make($data['password']),     
        ]);
    }
    
    
   public function showRegistrationForm(Request $request)
   { 
	   	$input = $request->all();
		$roles= \App\Role::all();	
		return view('/auth/register')->with(['roles'=>$roles]);	
   
   }
    
    public function register(Request $request)
    {
    	$input = $request->all();
    	
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));
        
        foreach ($input['role'] as $role)
        {
        	$user->roles()->attach($role);
        }

        return view('auth/register_success')->with(['name'=>$input['name'], 'login'=>$input['login'],'password'=>$input['password'],'roles'=>$user->roles]);
    }


}
