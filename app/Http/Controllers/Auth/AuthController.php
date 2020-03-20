<?php

namespace App\Http\Controllers\Auth;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
	public function __construct()
	{
	   	$this->middleware('auth');
	}
    
    protected function add_permissions_form(Request $request)
    {
       return view('auth/add_permissions_form');
    }    
    
     protected function add_permissions(Request $request)
    {
    	$this->permission_validator($request->all())->validate();
		$data=$request->all();
        Permission::create([
            'permission' => $data['permission'],
            'kod'=>$data['kod'],            
        ]);
        return view('auth/add_permissions')->with(['permission'=>$data['permission'],'kod'=>$data['kod']]);;        
    } 
    
     protected function permission_validator(array $data)
    {
        return Validator::make($data, [
            'permission' => ['required', 'string', 'max:100'],
            'kod' => ['required', 'string', 'max:30', 'unique:permissions','regex:/^[a-zA-Z0-9 _]+$/'],
        ]);
    }
     
     
    protected function add_role_form(Request $request)
    {
       $permissions=Permission::all();
       return view('auth/add_role_form')->with(['permissions'=>$permissions]);
    }    


	protected function add_role(Request $request)
    {
    	$this->role_validator($request->all())->validate();
		$data=$request->all();
		
        $role=Role::create(['role' => $data['role']]);

        foreach ($data['permission'] as $permission)
        {
        	$role->permissions()->attach($permission);
        }
        return view('auth/add_role')->with(['role'=>$role]);;        
    } 


	protected function role_validator(array $data)
    {
        return Validator::make($data, [
            'role' => ['required', 'string', 'max:50'],
            'permission'=>['required'],
        ]);
    }

}
