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
            ['name' => '555', 'email' => '555', 'password' => bcrypt('555'), 'role' => 1],
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
