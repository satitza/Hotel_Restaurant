<?php

use Illuminate\Database\Seeder;

class RateSuffixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rates = [
            ['rate_suffix' => '+', 'descriptions' => ''],
            ['rate_suffix' => '++', 'descriptions' => ''],
            ['rate_suffix' => 'Net', 'descriptions' => ''],
        ];

        foreach ($rates as $rate){
            $rate_suffix = New App\RateSuffix();
            $rate_suffix->rate_suffix = $rate['rate_suffix'];
            $rate_suffix->description = $rate['descriptions'];
            $rate_suffix->save();
        }
    }
}
