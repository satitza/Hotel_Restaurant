<?php

use Illuminate\Database\Seeder;

class TimeDinnersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $times = [
            ['time_dinner' => 'closed'],
            ['time_dinner' => '18.00'],
            ['time_dinner' => '18.30'],
            ['time_dinner' => '19.00'],
            ['time_dinner' => '19.30'],
            ['time_dinner' => '20.00'],
            ['time_dinner' => '20.30'],
            ['time_dinner' => '21.00'],
            ['time_dinner' => '21.30'],
            ['time_dinner' => '22.00'],
            ['time_dinner' => '22.30'],
            ['time_dinner' => '23.00'],
            ['time_dinner' => '23.30'],
        ];

        foreach ($times as $time) {
            $time_dinner = New App\TimeDinner();
            $time_dinner->time_dinner = $time['time_dinner'];
            $time_dinner->save();
        }
    }
}
