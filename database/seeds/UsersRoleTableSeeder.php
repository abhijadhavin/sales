<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User_roles;
class UsersRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->delete();
        User_roles::create(['user_id' => 1, 'role_id'=> 1]);
    }
}
