<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use App\Permission;

class Role extends Model
{
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role'
    ];
	
	
  public function permissions()
  {
    return $this->belongsToMany('App\Permission','roles_has_permissions');
  }

}
