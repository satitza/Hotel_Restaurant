<?php

use Illuminate\Database\Seeder;

class ActivesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $actives = [
            ['active' => 'Enable'],
            ['active' => 'Disable']
        ];

        foreach ($actives as $act){
            $active = new App\Actives;
            $active->active = $act['active'];
            $active->save();
        }
    }

}
