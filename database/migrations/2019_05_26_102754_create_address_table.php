<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('address', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->integer('cust_id');
			$table->string('building_type');
			$table->string('building_number_suffix');
			$table->string('building_name');
			$table->string('number_first');
			$table->string('number_last');
			$table->string('street_name');
			$table->string('street_type');
			$table->string('street_address1');
			$table->string('street_address2');
			$table->string('suburb');
			$table->string('city_town');
			$table->string('state');
			$table->string('postcode');
 			$table->tinyInteger('status')->default(1);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('address');
	}
}
