<?php

use Illuminate\Database\Seeder;

class DaysSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $days = New App\Days();
        $days->day = 'Sun';
        $days->save();
        
        $days = New App\Days();
        $days->day = 'Mon';
        $days->save();
        
        $days = New App\Days();
        $days->day = 'Tue';
        $days->save();
        
        $days = New App\Days();
        $days->day = 'Wed';
        $days->save();
        
        $days = New App\Days();
        $days->day = 'Thu';
        $days->save();
        
        $days = New App\Days();
        $days->day = 'Fri';
        $days->save();
        
        $days = New App\Days();
        $days->day = 'Sat';
        $days->save();
    }

}
