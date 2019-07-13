<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
	
	public $timestamps = false;
	//user_id, first_name, middle_name,last_name, contact, customer_type, op_date, status
	protected $fillable = [
		'user_id',
		'executive_id', 
		'first_name', 
		'middle_name',
		'last_name', 
		'contact', 
		'email',
		'customer_type', 
		'op_date', 
		'comments',
		'status'
	];
}
