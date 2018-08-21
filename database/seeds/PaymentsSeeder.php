<?php

use Illuminate\Database\Seeder;

class PaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payments = [
            ['payment' => 'Disable', 'descriptions' => ''],
            ['payment' => 'Paypal', 'descriptions' => ''],
            ['payment' => 'Reddot', 'descriptions' => ''],
        ];

        foreach ($payments as $pay){
            $payment = New App\Payment();
            $payment->payment = $pay['payment'];
            $payment->description = $pay['descriptions'];
            $payment->save();
        }
    }
}
