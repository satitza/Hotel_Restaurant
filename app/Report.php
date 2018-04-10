<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';

    public function Hotels()
    {
        return $this->belongsTo(Hotels::class, 'hotel_id');
    }

    public function Restaurants()
    {
        return $this->belongsTo(Restaurants::class, 'restaurant_id');
    }

    public function Offers()
    {
        return $this->belongsTo(Offers::class, 'offer_id');
    }

    public function BookingStatus()
    {
        return $this->belongsTo(BookingStatus::class, 'booking_status');
    }
}
