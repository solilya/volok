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
		$input = $request->all();
		
		if (isset($input['del_id']))
		{
			Client::destroy($input['del_id']);
			unset($request['del_id']);
		}	
		
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
		
		if ($request->isMethod('post')&&(!isset($input['del_id']))) $clients=$q->paginate(40,'*','page',1);		
		else $clients=$q->paginate(40); 
#		$clients=Client::paginate(40);
		
		session()->flashInput($request->input());
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
			if (($col !='simcard_old')and ($col !='person_old')) $client->$col=$input[$col];		
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
	
	
	public function addform(Request $request)
	{	
		$gbr=DB::table('clients')
             ->select('gbr')
             ->distinct()
             ->get();
		return view('/addform')->with(['allgbr'=>$gbr]);
	}
	
	public function add(Request $request)
	{
	
		$input = $request->all();			
	 	$fields=$request->only(['name','type','pult_number','ohran_system','address','person','dogovor','ikeys','payment','time','simcard','simcard2','kadastr','gbr']);	
		$client = Client::create($fields);
				
		return view('/view')->with(['client'=>$client]);	
	}

}
