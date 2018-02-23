<?php

use Illuminate\Database\Seeder;

class HotelsListSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {


        for ($i = 1; $i < 50; $i++) {
            $status = 1;

            if ($i > 20) {
                $status = 2;
            }
            $hotels = New App\Hotels();
            $hotels->hotel_name = 'hotel_' . $i;
            $hotels->active_id = $status;
            $hotels->hotel_comment = 'hotel_' . $i;
            $hotels->save();
        }
    }

}
