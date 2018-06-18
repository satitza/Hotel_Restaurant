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
        $user->email = 'dining@compasshospitality.com';
        $user->password = bcrypt('dr823c1HEE');
        $user->user_role = 1;
        $user->save();

        $user = New App\User();
        $user->name = 'Satit Porntepanon';
        $user->email = 'st_satitza@hotmail.com';
        $user->password = bcrypt('dr823c1HEE');
        $user->user_role = 1;
        $user->save();

        $user = New App\User();
        $user->name = 'admin';
        $user->email = 'admin@admin.com';
        $user->password = bcrypt('dr823c1HEE');
        $user->user_role = 1;
        $user->save();

        $user = New App\User();
        $user->name = 'editor';
        $user->email = 'editor@editor.com';
        $user->password = bcrypt('dr823c1HEE');
        $user->user_role = 2;
        $user->save();

        $user = New App\User();
        $user->name = 'report';
        $user->email = 'report@report.com';
        $user->password = bcrypt('dr823c1HEE');
        $user->user_role = 3;
        $user->save();

        $user = New App\User();
        $user->name = 'user';
        $user->email = 'user@user.com';
        $user->password = bcrypt('dr823c1HEE');
        $user->user_role = 4;
        $user->save();
    }
}
