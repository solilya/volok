<?php	

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Validator;
use App\Client;
use App\Ticket;
use App\Comment;
use App\Sms_na_pribor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Schema;
use App\Goip;



class TicketController extends Controller
{
	public function addform(Request $request)
	{
		$client=Client::find($request->input('id'));		
		return view('/ticket/addform')->with(['client'=>$client]);
	}
	
	public function add(Request $request)
	{	
		$input = $request->all();		
	 	$fields=$request->only(['mes']);	
	 	if (!isset($input['free_ticket'])) $fields['client_id']=$input['client_id'];	 	
	 	
	 	$fields['date']= DB::raw('NOW()');
	 	$fields['status']=0;
	 	if (!isset($input['department_id'])) 
	 	{ 
	 		print "Ошибка: не указан адресат заявки при создании заявки" ;
	 		exit;
	 	}
	 	foreach ($input['department_id'] as $id)
	 	{
	 		$fields['department_id']=$id;
			$ticket = Ticket::create($fields);
		}		
		$ticket = Ticket::find($ticket->id);
		return view('/ticket/view')->with(['ticket'=>$ticket, 'oper'=>'add','department_id'=>$input['department_id']]);	
	}


	public function add_comment(Request $request)
	{	
		$input = $request->all();					
	 	$fields=$request->only(['mes']);	
	 	if (!isset($input['id'])) 
	 	{ 
	 		print "Ошибка: не указан id заявки при добавлении комментария" ;
	 		exit;
	 	}
	 	$fields['ticket_id']=$input['id'];
		$comment = Comment::create($fields);				
		$ticket = Ticket::find($input['id']);
		$ticket->num_mes++;
		$ticket->read=0;
		$ticket->save();
		return view('/ticket/view')->with(['ticket'=>$ticket, 'oper'=>'view']);	
	}


	public function view(Request $request)
	{		
		$input = $request->all();	
		$ticket = Ticket::find($input['id']);
		$ticket->read=1;
		$ticket->save();
		return view('/ticket/view')->with(['ticket'=>$ticket,'oper'=>'view']);	
	}
	
	
	public function accept_teh_ticket(Request $request)
	{
		$input = $request->all();	
		$ticket = Ticket::find($input['ticket_id']);
		$ticket->status=10;  //Заявка принята тех. отделом
		$ticket->save();	
		return redirect()->route('teh_view', ['id' => $ticket['client_id'],'ticket_id'=>$input['ticket_id']]);
	}
	
	
	public function mark_unread(Request $request)
	{		
		$input = $request->all();	
		$ticket = Ticket::find($input['id']);
		$ticket->read=0;
		$ticket->save();
		return view('/window_close');	
	}
		
	public function list(Request $request)
	{
		$input = $request->all();		
		$tickets=$this->search_ticket($input);
				
		return view('/ticket/list')->with(['tickets'=>$tickets]);	
	}
	
	public function teh_list(Request $request)
	{
		$input = $request->all();
		$input['department_id']=1;
		$input['all']=1;
		$tickets=$this->search_ticket($input);
		return view('/ticket/teh_list')->with(['tickets'=>$tickets]);	
		
	}
	
	public function edit_teh(Request $request)
	{		
		$ticket=Ticket::find($request->input('id'));
		if (!empty($ticket['client_id'])) $client = Client::find($ticket['client_id']);
		else $client='';
		return view('/ticket/edit_teh')->with(['ticket'=>$ticket,'client'=>$client]);	
	}	
	
	
	public function update_teh_ticket(Request $request)
	{
	
		$input = $request->all();	
		$ticket = Ticket::find($input['id']);
		$columns = ['status','quick','TO','neopros','type','remind_id','zakaz_naryad_made'];	
		foreach ($columns as $col)
		{
			if (isset($input[$col])) $ticket->$col=$input[$col];		
		}	
		
		if (!isset($input['quick'])) $ticket->quick=0;		
		if (!isset($input['TO'])) $ticket->TO=0;		
		if (!isset($input['neopros'])) $ticket->neopros=0;		
		
		if (!empty($input['work_date'])) $ticket->work_date=Convert_date_to_MySQL($input['work_date']);
		if (!empty($input['zakaz_naryad_date'])) $ticket->zakaz_naryad_date=Convert_date_to_MySQL($input['zakaz_naryad_date']);		
		
		$ticket_status=config('volok.ticket_status');		
		$add_teh_comment=htmlspecialchars($input['add_teh_comment']);		
		$d=date("d.m.Y H:i:s");
		$ticket->teh_comment.="<b>Обновление от $d (Холодкова М.А.):</b> /<font color='red'>".$ticket_status[$input['status']]."</font><BR><font color='Indigo'>".$add_teh_comment."</font><BR>";
				
		$ticket->save();
		return redirect()->route('teh_view', ['ticket_id' => $input['id'],'client_id'=>$ticket->client_id]);	
	}
	
	
	
	public function search_ticket($input)
		{

		$lim=30;
		if (empty($input['department_id'])) $department_id='';
		else $department_id=$input['department_id'];
		
		if ((isset($input['lim']))&&($lim!='')) $lim=$input['lim'];
		
		$unread=1;
		if ((isset($input['all']))&&($input['all']==1)) $unread=0;
		
		$beg_date='';		
		$end_date='';
		if ((isset($input['beg_date']))&&($input['beg_date']!='')) 	
		{ 
			$beg_date=Convert_date_to_MySQL($input['beg_date']);
			$beg_date="$beg_date 00:00:00";
		}
		if ((isset($input['end_date']))&&($input['end_date']!='')) 	
		{
			$end_date=Convert_date_to_MySQL($input['end_date']);
			$end_date="$end_date 23:59:59";
		}
		
		if ((isset($input['search']))&&($input['search']!=''))		
		{ 				
				$tickets=Ticket::where(function ($query) use ($input) {
					$query->whereHas('client', function ($query) use ($input) {
  						$query->where('person', 'like', '%'.$input['search'].'%') 
	  						->orwhere('tel', 'like', '%'.$input['search'].'%')
  							->orwhere('tel2', 'like', '%'.$input['search'].'%')
							->orwhere('tel3', 'like', '%'.$input['search'].'%') 
							->orwhere('dogovor', 'like', '%'.$input['search'].'%') 
							->orwhere('pult_number', 'like', '%'.$input['search'].'%') 
  							->orwhere('address', 'like', '%'.$input['search'].'%') ;  							  					
  							})									
  					->orwhere('mes', 'like', '%'.$input['search'].'%')  					
  					->orwhere('id', 'like', '%'.$input['search'].'%') ;  				
  				})->with('client')
  				->where(function ($query) use ($beg_date,$end_date) {
		           	$query->when($beg_date, function ($query, $beg_date) {
		                    return $query->where('date','>=', $beg_date); })
		            ->when($end_date, function ($query, $end_date) {
		                    return $query->where('date','<=', $end_date); });
		             })
		       ->when($department_id, function ($query,$department_id) {
		       		return $query->where('department_id','=',$department_id); })
                ->orderBy('date','desc')->paginate($lim);
		}
		elseif (((isset($input['beg_date']))&&($input['beg_date']!=''))||((isset($input['end_date']))&&($input['end_date']!='')))
		{
				$tickets=Ticket::with('client')
				->when($beg_date, function ($query,$beg_date) {					
  					 return $query->where('date','>=',$beg_date);  })
				->when($end_date, function ($query,$end_date) {					
  					 return $query->where('date','<=',$end_date);  })
  				 ->when($department_id, function ($query,$department_id) {
		       		return $query->where('department_id','=',$department_id); })
  				->orderBy('date','desc')->paginate($lim); 
		}
		else 
		{ 
			$tickets=Ticket::with('client')
				->when($unread, function ($query) {					
  					 return $query->where('read','0');  })
  				 ->when($department_id, function ($query,$department_id) {
		       		return $query->where('department_id','=',$department_id); })
  				->orderBy('date','desc')->paginate($lim); 
		}
/*		else 
		{
			$tickets=Ticket::with('client')->orderBy('date','desc')->paginate($lim);
		}*/
	
		return $tickets;
	}	


	public function send_sms_for_pribor_form(Request $request)
	{
		$input = $request->all();
		$client= Client::find($input['client_id']);
		$sms=Sms_na_pribor::select('id','name','sms','type')->where('type',$client->ohran_system_type)->distinct()->get();
		return view('/ticket/sms_na_pribor')->with(['sms_na_pribor'=>$sms,'client'=>$client]);	
	}	

	
	public function sms_history_for_pribor(Request $request)
	{
		$goip= New Goip();	
		$goip->sms_history();
		return view('/ticket/sms_history_for_pribor')->with(['sendid'=>$goip->sendid,'rcv'=>$goip->rcv]);	
	}	

	
}
?>