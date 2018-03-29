<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UsersTableSeeder::class);
        $this->call(UserRolesSeeder::class);
        $this->call(ActivesTableSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(CreateAdministratorAccountSeeder::class);
        $this->call(HotelsListSeeder::class);
        //$this->call(RestaurantListSeeder::class);
        $this->call(DaysSeeder::class);
        $this->call(TimeLunchsSeeder::class);
        $this->call(TimeDinnersSeeder::class);
        //$this->call(SetMenuListSeeder::class);
    }
}
