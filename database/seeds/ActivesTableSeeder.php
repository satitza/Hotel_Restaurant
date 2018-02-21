<?php

use Illuminate\Database\Seeder;

class ActivesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $actives = new App\Actives;
        $actives->active = 'Enable';
        $actives->save();
        
        $actives = new App\Actives;
        $actives->active = 'Disable';
        $actives->save();
    }

}
