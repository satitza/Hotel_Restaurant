<?php

use Illuminate\Database\Seeder;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencries = [
            ['currency' => 'THB', 'descriptions' => 'Thailand Currency'],
            ['currency' => 'MYR', 'descriptions' => 'Malaysia Currency'],
            ['currency' => 'GBP', 'descriptions' => 'English Currency'],
        ];

        foreach ($currencries as $cur){
            $currency = New App\Currency();
            $currency->currency = $cur['currency'];
            $currency->description = $cur['descriptions'];
            $currency->save();
        }

    }
}
