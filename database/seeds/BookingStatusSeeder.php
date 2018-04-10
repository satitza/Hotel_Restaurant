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
        $booking_status = new App\BookingStatus;
        $booking_status->booking_status = 'Pending';
        $booking_status->save();

        $booking_status = new App\BookingStatus;
        $booking_status->booking_status = 'Complete';
        $booking_status->save();
    }
}
