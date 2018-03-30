<?php

use Illuminate\Database\Seeder;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_roles = New App\UserRole();
        $user_roles->role = 'admin';
        $user_roles->save();

        $user_roles = New App\UserRole();
        $user_roles->role = 'editor';
        $user_roles->save();

        $user_roles = New App\UserRole();
        $user_roles->role = 'report';
        $user_roles->save();

        $user_roles = New App\UserRole();
        $user_roles->role = 'user';
        $user_roles->save();
    }
}
