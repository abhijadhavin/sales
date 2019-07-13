<?php

use Illuminate\Database\Seeder;
use App\Roles;
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $currentDate = date('Y-m-d H:m:s');
        DB::table('roles')->delete();
        Roles::create(['name' => 'Super Admin', 'status'=> '1', 'created_at'=> $currentDate, 'updated_at' => $currentDate]);
        Roles::create(['name' => 'Admin', 'status'=> '1', 'created_at'=> $currentDate, 'updated_at' =>$currentDate]);
        Roles::create(['name' => 'Agent', 'status'=> '1', 'created_at'=> $currentDate, 'updated_at' =>$currentDate]);
    }
}
