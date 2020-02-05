<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client_helper extends Model
{
    public $timestamps = false;
    protected $fillable=['name','tel','tel1','tel2','email','descr','sms','operational','opening','client_id'];
       
  	public function client()
  	{
    	return $this->belongsTo('App\Client');
  	}
}
