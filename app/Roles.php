<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    //
    public $timestamps = false;
    //
    protected $fillable = [
		'id',
		'name',	 
		'status'	
	];
}
