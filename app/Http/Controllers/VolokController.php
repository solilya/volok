<?php	

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Schema;

class VolokController extends Controller
{
    
	public function index(Request $request)
	{
		
		$input=$_REQUEST;	
		
		$param=['id', 'pult_number', 'address', 'dogovor','gbr'];
		$q = DB::table('clients');
		
		foreach ($param as $key)
		{
			if(isset($input[$key]) && !empty($input[$key])) 
			{
		        $q = $q->where($key, 'LIKE', '%'.$input[$key].'%');
			}
		}
		
		if (isset($input['name']) && !empty($input['name'])) 
		{
			$q=$q->where(function ($query) 
			{ 
				$input=$_REQUEST;
				$query->where('name', 'LIKE', '%'.$input['name'].'%')
                      ->orWhere('person', 'LIKE', '%'.$input['name'].'%');
            });
		}		
		
		if ($request->isMethod('post')) $clients=$q->paginate(50,'*','page',1);		
		else $clients=$q->paginate(50); 
		
		session()->flashInput($request->input());
#		$clients=Client::paginate(50);
		return view('/find')->with(compact('clients'));
	}
	
	public function editform(Request $request)
	{		

		$clients=DB::table('clients')->find($request->input('id'));
		$gbr=DB::table('clients')
             ->select('gbr')
             ->distinct()
             ->get();
		
		return view('/editform')->with(['client'=>$clients,'allgbr'=>$gbr]);	
	}
	
	

	public function update(Request $request)
	{
	
		$input = $request->all();	
		$client = Client::find($input['id']);
		$columns = Schema::getColumnListing('clients');
		
		foreach ($columns as $col)
		{
			$client->$col=$input[$col];		
		}
		
		$client->save();
		return redirect()->route('view', ['id' => $input['id']]);	
	}


	public function view(Request $request)
	{
	
		$input = $request->all();	
		$client = Client::find($input['id']);
		return view('/view')->with(['client'=>$client]);	
	}
	
	public function new_object(Request $request)
	{
	
		$input = $request->all();	

		return view('/view')->with(['client'=>$client]);	
	}


}
