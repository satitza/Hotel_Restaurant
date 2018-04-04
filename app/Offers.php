<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offers extends Model
{
    protected $table = 'offers';

    public function Image() {
        return $this->hasMany(Image::class);
    }

    public function Hotels()
    {
        return $this->belongsTo(Hotels::class, 'hotel_id');
    }

    public function Restaurants()
    {
        return $this->belongsTo(Restaurants::class, 'restaurant_id');
    }

    public function BookCheckBalance()
    {
        return $this->hasMany(BookCheckBalance::class);
    }
}
