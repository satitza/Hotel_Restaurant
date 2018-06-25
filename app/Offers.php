<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offers extends Model
{
    protected $table = 'offers';

    public function Image()
    {
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

    public function Report()
    {
        return $this->hasMany(Report::class);
    }

    public function Termsth()
    {
        return $this->hasMany(Termsth::class);
    }

    public function Termsen()
    {
        return $this->hasMany(Termsen::class);
    }

    public function Termscn()
    {
        return $this->hasMany(Termscn::class);
    }

    public function Lunch_Currency()
    {
        return $this->belongsTo(Currency::class, 'lunch_currency_id');
    }

    public function Dinner_Currency()
    {
        return $this->belongsTo(Currency::class, 'dinner_currency_id');
    }
}
