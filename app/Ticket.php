<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public $timestamps = false;
    protected $fillable=['user_id','department_id','mes','date','read','num_mes','client_id','status','tehnik_id','quick','work_date','teh_comment','remind_id','type','zakaz_naryad_made','zakaz_naryad_date','TO','neopros'];
       
  	public function client()
  	{
#  		return $this->hasOne('App\Client');
    	return $this->belongsTo('App\Client');
  	}
  	
  	public function comments()
   	{
   		return $this->hasMany('App\Comment');
   	} 
  	
  	public function getDateAttribute($value)
    {    	
        return Convert_timestamp_to_HTML_date_first($value);
    }
    
    public function getWorkDateAttribute($value)
    {    	
        return Convert_date_to_HTML($value);
    }
	
	public function getZakazNaryadDateAttribute($value)
    {    	
        return Convert_date_to_HTML($value);
    }
}

?>