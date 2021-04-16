<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins=[
            [
                'id'=>'1',
                'name'=>'Administrator',
                'userName'=>'instantadmin',
                'contact'=>'09082220910',
                'address'=>'Napo, Carcar City, Cebu',
                'email'=>'iplotadmin@gmail.com',
                'password'=>bcrypt('@dm!n'),
                'userType'=>'2',
                'remember_token'=>str_random(10),
                

            ],
        ];
    
        DB::table('users')->insert($admins);
       
            }
}
