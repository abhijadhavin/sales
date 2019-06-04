<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cust_id');
            $table->string('cli_number');
            $table->string('product_type');
            $table->string('plan_name');
            $table->string('plan_price');
            $table->string('plan_type');
            $table->string('handset_type');
            $table->string('contract_stage');
            $table->string('id_status');
            $table->string('direct_debit_details');
            $table->string('order_status');
            $table->date('order_status_date');            
            $table->tinyInteger('status')->default(1);
            $table->date('created_date')->nullable();
            $table->date('update_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
