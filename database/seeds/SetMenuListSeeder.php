<?php

use Illuminate\Database\Seeder;


class SetMenuListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i < 20; $i++){
            $set_menu = new App\SetMenu();
            $set_menu->hotel_id = $i;
            $set_menu->restaurant_id = $i;
            $set_menu->menu_name = 'menu_'.$i;
            $set_menu->menu_date_start = '2018/02/14';
            $set_menu->menu_date_end = '2018/02/14';
            $set_menu->menu_date_select = 'null';
            $set_menu->menu_time_lunch_start = 'closed';
            $set_menu->menu_time_lunch_end = 'closed';
            $set_menu->menu_time_dinner_start = '18.00';
            $set_menu->menu_time_dinner_end = '23.00';
            $set_menu->menu_price = '300.50';
            $set_menu->menu_guest = 15;
            $set_menu->menu_comment = 'menu_'.$i;
            $set_menu->save();
        }
    }
}
