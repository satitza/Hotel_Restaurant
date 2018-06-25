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
        $roles = [
            ['role' => 'admin'],
            ['role' => 'editor'],
            ['role' => 'report'],
            ['role' => 'user'],
        ];

        foreach ($roles as $role) {
            $user_roles = New App\UserRole();
            $user_roles->role = $role['role'];
            $user_roles->save();
        }
    }
}
