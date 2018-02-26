<?php

use Illuminate\Database\Seeder;

class TimeLunchsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $time_lunch = New App\TimeLunch();
        $time_lunch->time_lunch = 'closed';
        $time_lunch->save();

        $time_lunch = New App\TimeLunch();
        $time_lunch->time_lunch = '06.00';
        $time_lunch->save();
        
        $time_lunch = New App\TimeLunch();
        $time_lunch->time_lunch = '06.30';
        $time_lunch->save();
        
        $time_lunch = New App\TimeLunch();
        $time_lunch->time_lunch = '07.00';
        $time_lunch->save();
        
        $time_lunch = New App\TimeLunch();
        $time_lunch->time_lunch = '07.30';
        $time_lunch->save();
        
        $time_lunch = New App\TimeLunch();
        $time_lunch->time_lunch = '08.00';
        $time_lunch->save();
        
        $time_lunch = New App\TimeLunch();
        $time_lunch->time_lunch = '08.30';
        $time_lunch->save();
        
        $time_lunch = New App\TimeLunch();
        $time_lunch->time_lunch = '09.00';
        $time_lunch->save();
        
        $time_lunch = New App\TimeLunch();
        $time_lunch->time_lunch = '09.30';
        $time_lunch->save();
        
        $time_lunch = New App\TimeLunch();
        $time_lunch->time_lunch = '10.00';
        $time_lunch->save();
        
        $time_lunch = New App\TimeLunch();
        $time_lunch->time_lunch = '10.30';
        $time_lunch->save();
        
        $time_lunch = New App\TimeLunch();
        $time_lunch->time_lunch = '11.00';
        $time_lunch->save();
        
        $time_lunch = New App\TimeLunch();
        $time_lunch->time_lunch = '12.30';
        $time_lunch->save();
        
        $time_lunch = New App\TimeLunch();
        $time_lunch->time_lunch = '13.00';
        $time_lunch->save();
        
        $time_lunch = New App\TimeLunch();
        $time_lunch->time_lunch = '13.30';
        $time_lunch->save();
        
        $time_lunch = New App\TimeLunch();
        $time_lunch->time_lunch = '14.00';
        $time_lunch->save();
        
        $time_lunch = New App\TimeLunch();
        $time_lunch->time_lunch = '14.30';
        $time_lunch->save();
        
        $time_lunch = New App\TimeLunch();
        $time_lunch->time_lunch = '15.00';
        $time_lunch->save();
        
        $time_lunch = New App\TimeLunch();
        $time_lunch->time_lunch = '15.30';
        $time_lunch->save();
        
        $time_lunch = New App\TimeLunch();
        $time_lunch->time_lunch = '16.00';
        $time_lunch->save();
        
        $time_lunch = New App\TimeLunch();
        $time_lunch->time_lunch = '16.30';
        $time_lunch->save();
        
        $time_lunch = New App\TimeLunch();
        $time_lunch->time_lunch = '17.00';
        $time_lunch->save();
        
        $time_lunch = New App\TimeLunch();
        $time_lunch->time_lunch = '17.30';
        $time_lunch->save();
    }

}
