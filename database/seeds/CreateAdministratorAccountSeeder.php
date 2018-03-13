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
        $user = New App\User();
        $user->name = 'Administrator';
        $user->email = 'st_satitza@hotmail.com';
        $user->password = bcrypt('dr823c1HEE');
        $user->user_role = 1;
        $user->save();
    }
}
