<?php

use Illuminate\Database\Seeder;

class RestaurantListSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
           
        for ($i = 1; $i < 30; $i++) {
            $restaurant = New App\Restaurants();
            $restaurant->restaurant_name = 'restaurant_' . $i;
            $restaurant->hotel_id = $i;
            $restaurant->active_id = '1';
            $restaurant->restaurant_comment = 'restaurant_' . $i;
            $restaurant->save();
        }
    }

}
