<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
       public $timestamps = false;
       protected $fillable=['name','type','pult_number','ohran_system','address','person','dogovor','ikeys','payment','time','simcard','simcard2','kadastr','gbr'];
}
