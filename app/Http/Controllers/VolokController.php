<?php	

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Validator;
use App\Client;
use App\Client_helper;
use App\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Schema;

class VolokController extends Controller
{
   	public function __construct()
	{
    	$this->middleware('auth');
	}

	public function index(Request $request)
	{
		$input = $request->all();
		
		if (isset($input['del_id']))
		{
			Client::destroy($input['del_id']);
			unset($request['del_id']);
		}	
		
		$param=['id', 'pult_number', 'address', 'dogovor','gbr'];
		$q = DB::table('clients'); #query builder

		
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
		
		$param=['status'];
		
		foreach ($param as $key)
		{
			if(isset($input[$key]) && !empty($input[$key])) 
			{
		        $q = $q->where($key, $input[$key]);
			}
		}
		
		if ($request->isMethod('post')&&(!isset($input['del_id']))) $clients=$q->paginate(40,'*','page',1);		
		else $clients=$q->paginate(40); 			
/* 
#отображение доверенных лиц		
		foreach ($clients as $client)	
		{
			$cl= New Client();
			$cl->id=$client->id;
			$client->person_list=$cl->getPersonListAttribute();		
		}
*/
#		$clients=Client::paginate(40);

		session()->flashInput($request->input());
		return view('/find')->with(['clients'=>$clients]);
	}
	
	public function editform(Request $request)
	{		
#		$clients=DB::table('clients')->find($request->input('id'));
		$clients=Client::find($request->input('id'));

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
			if (($col !='ohran_system_type') and ($col !='simcard_old')and ($col !='person_old')) $client->$col=$input[$col];		
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

	public function teh_view(Request $request)
	{		
		$input = $request->all();
		if (isset($input['id'])) $client = Client::find($input['id']);
		else $client='';
		$ticket = Ticket::find($input['ticket_id']);
		return view('/teh_view')->with(['client'=>$client, 'ticket'=>$ticket]);	
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
	 	$fields=$request->only(['name','type','pult_number','ohran_system','address','person','dogovor','ikeys','payment','time','simcard','simcard2','kadastr','gbr','status','tel','tel2','tel3','email','sms']);	
		$client = Client::create($fields);
				
		return view('/view')->with(['client'=>$client]);	
	}

#Доверенные лица

public function view_helpers(Request $request)
	{	
		$clients=Client::find($request->input('id'));

		return view('/view_helpers')->with(['client'=>$clients ]);	
	}

	public function del_helpers(Request $request)
	{
		$input = $request->all();
		if (isset($input['del_helper_id']))
		{
			Client_helper::destroy($input['del_helper_id']);
			unset($request['del_helper_id']);
		}			
		return $this->view_helpers($request);
	}

	public function edit_helpers(Request $request)
	{		
		$person=Client_helper::find($request->input('id'));
		$client=Client::find($person->client_id);
		return view('/edit_helpers')->with(['person'=>$person,'client'=>$client]);	
	}	

	public function update_helpers(Request $request)
	{
		$input = $request->all();	
		$helper = Client_helper::find($input['id']);
		$columns = Schema::getColumnListing('client_helpers');
		
		foreach ($columns as $col)
		{ 
			if (($col !='client_id')and ($col !='id') and (isset($input[$col]))) $helper->$col=$input[$col]; 
		}
		
		if (!isset($input['operational'])) $helper->operational=0;
		if (!isset($input['opening'])) $helper->opening=0;		
		
		$helper->save();
		$clients=Client::find($helper->client_id);
		return view('/view_helpers')->with(['client'=>$clients ]);	
	}

		
	public function add_helpers (Request $request)
	{
	
		$input = $request->all();			
	 	$fields=$request->only(['name','tel','tel2','tel3','email', 'descr','sms','operational','opening','client_id']);	
		$client_helper = Client_helper::create($fields);
		$clients=Client::find($input['client_id']);				
		return view('view_helpers')->with(['client'=>$clients ]);	
	}
}
?>