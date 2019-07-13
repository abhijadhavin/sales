<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    //
    public $timestamps = false;

    protected $table = 'center';
    //
    protected $fillable = [
		'id',
		'name',	 
		'status'	
	];
}
