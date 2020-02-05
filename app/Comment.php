<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable=['user_id','mes','ticket_id','client_id'];
       
  	public function ticket()
  	{
    	return $this->belongsTo('App\Ticket');
  	}
  	
  	public function getCreatedAtAttribute($value)
    {    	
        return Convert_timestamp_to_HTML_date_first($value);
    }
}

?>