<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_Center extends Model
{    
    //
    public $timestamps = false;

    protected $table = 'user_center';
    //
    protected $fillable = [
		'id',
		'user_id',	 
		'center_id'	
	]; 
}
