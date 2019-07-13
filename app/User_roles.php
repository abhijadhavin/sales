<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_roles extends Model
{
    //
    public $timestamps = false;
    //
    protected $fillable = [
		'id',
		'user_id',	 
		'role_id'	
	];    
	
}
