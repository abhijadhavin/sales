<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
	public $table = "address";
	public $timestamps = false;
    //
    protected $fillable = [
		'cust_id'.
		'building_type',
		'building_number_suffix',
		'building_name',
		'number_first',
		'number_last',
		'street_name',
		'street_type',
		'street_address1',
		'street_address2',
		'suburb',
		'city_town',
		'state',
		'postcode',
		'status'	
	];
}
