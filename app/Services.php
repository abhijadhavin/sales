<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
	public $timestamps = false;
    //
    protected $fillable = [
		'user_id',
		'cli_number',
		'product_type',
		'plan_name',
		'plan_price',
		'plan_type',
		'handset_type',
		'contract_stage',
		'id_status',
		'direct_debit_details',
		'order_status',
		'order_status_date',
		'status'	
	];
}
