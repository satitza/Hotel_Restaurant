<?php

use Illuminate\Database\Seeder;

class BookingStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            ['status' => 'Pending'],
            ['status' => 'Complete']
        ];

        foreach ($status as $sta){
            $booking_status = new App\BookingStatus;
            $booking_status->booking_status = $sta['status'];
            $booking_status->save();
        }
    }
}
