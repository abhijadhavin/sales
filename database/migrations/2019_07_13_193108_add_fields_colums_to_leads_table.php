<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsColumsToLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('leads', 'postcode')) {
            Schema::table('leads', function (Blueprint $table) {
                $table->dropColumn('building_type');
                $table->dropColumn('building_number_suffix');
                $table->dropColumn('building_name');
                $table->dropColumn('number_first');
                $table->dropColumn('number_last');
                $table->dropColumn('street_name');
                $table->dropColumn('street_type');
                $table->dropColumn('street_address1');
                $table->dropColumn('street_address2');
                $table->dropColumn('suburb');
                $table->dropColumn('city_town');
                $table->dropColumn('state');
                $table->dropColumn('postcode');
            });
        }         
    }
}
