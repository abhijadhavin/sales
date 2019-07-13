<?php 
use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder {	
    public function run()
    {
        DB::table('users')->delete();
        User::create([
        	'name' => 'Super Admin',
        	'email' => 'admin@salesform.com',        	
        	'password' => Hash::make('admin@123')
        ]);
    }
}