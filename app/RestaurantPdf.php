<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestaurantPdf extends Model
{
    protected $table = 'restaurant_pdfs';

    public function Restaurants(){
        return $this->belongsTo(Restaurants::class, 'restaurant_id');
    }
}
