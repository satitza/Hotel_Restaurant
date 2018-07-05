<?php

use Illuminate\Database\Seeder;

class CreateAdministratorAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [

        ];

        foreach ($users as $use){
            $user = New App\User();
            $user->name = $use['name'];
            $user->email = $use['email'];
            $user->password = $use['password'];
            $user->user_role = $use['role'];
            $user->save();
        }
    }
}
