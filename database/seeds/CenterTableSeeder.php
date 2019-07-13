<?php

use Illuminate\Database\Seeder;
use App\Center;
class CenterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {     	
        Center::create(['name' => 'Mumbai', 'status'=> '1']);
        Center::create(['name' => 'Pune', 'status'=> '1']);
        Center::create(['name' => 'Baramati', 'status'=> '1']);
    }
}
