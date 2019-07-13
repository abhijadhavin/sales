<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leads extends Model
{
   public $timestamps = false;
	//user_id, first_name, middle_name,last_name, contact, customer_type, op_date, status
	protected $fillable = [
		'user_id', 
		'first_name', 
		'middle_name',
		'last_name', 
		'contact', 
		'customer_type', 
		'op_date', 
		'status',
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
		'postcode'
	];

}
