<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client_helpers extends Model
{
       public $timestamps = false;
       protected $fillable=['name','tel','tel1','tel2','email','dsecr','nosms','add_remove','full_sms','operational','opening'];
}
