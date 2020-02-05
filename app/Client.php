<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Client extends Model
{
    public $timestamps = false;
    protected $fillable=['name','type','pult_number','ohran_system','address','person','dogovor','ikeys','payment','time','simcard','simcard2','kadastr','gbr','status','email' ,'tel', 'tel2', 'tel3','sms'];
    protected $appends = ['status_descr','person_list'];
       
       
    public function getStatusDescrAttribute()
    {    	
    	$status=Config::get('volok.client_status');
       	if (empty($this->status)) return '';
        return $status[$this->status];
    } 
    
    public function getPersonListAttribute()
    {    	
    	$persons= Client_helper::where('client_id', $this->id)->get();
   		$val='';	
		foreach ($persons as $person)
		{
			if ($val !='') { $val=$val."<br>" ;}
			$val=$val.$person->name.' '.$person->tel;
			if (isset($person['tel2'])&& ($person['tel2']!='')) {$val=$val.', '.$person['tel2']; }
			if (isset($person['tel3'])&& ($person['tel3']!='')) {$val=$val.', '.$person['tel3']; }			
		}    	
		return $val;
    } 
   	
   	public function Client_helpers()
   	{
   		return $this->hasMany('App\Client_helper');
   	} 
      
  	public function delete()
	{
    \DB::beginTransaction();

     $this->Client_helpers()->delete() ;

    $result = parent::delete();

    \DB::commit();

    return $result;
	}

}
?>