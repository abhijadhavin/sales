<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customers', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->integer('user_id');
			$table->integer('executive_id');
			$table->string('first_name');
			$table->string('middle_name');
			$table->string('last_name');
			$table->string('contact');
			$table->string('email');            
			$table->string('customer_type');
			$table->date('op_date')->nullable();
			$table->text('comments')->nullable();
			$table->tinyInteger('status')->default(1);
			$table->date('created_date')->nullable();
			$table->date('updated_date')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('customers');
	}
}
