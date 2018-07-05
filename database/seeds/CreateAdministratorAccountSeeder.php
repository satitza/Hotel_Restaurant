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
            ['name' => 'Administrator', 'email' => 'dining@compasshospitality.com', 'password' => bcrypt('dr823c1HEE'), 'role' => 1],
            ['name' => 'Satit Porntepanon', 'email' => 'st_satitza@hotmail.com', 'password' => bcrypt('dr823c1HEE'), 'role' => 1],
            ['name' => 'Admin', 'email' => 'admin@admin.com', 'password' => bcrypt('dr823c1HEE'), 'role' => 1],
            ['name' => 'Editor', 'email' => 'editor@editor.com', 'password' => bcrypt('dr823c1HEE'), 'role' => 2],
            ['name' => 'Report', 'email' => 'report@report.com', 'password' => bcrypt('dr823c1HEE'), 'role' => 3],
            ['name' => 'User', 'email' => 'user@user.com', 'password' => bcrypt('dr823c1HEE'), 'role' => 4],
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
