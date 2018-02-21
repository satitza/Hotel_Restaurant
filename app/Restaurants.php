<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurants extends Model
{
    protected $table = 'restaurants';
       
    public function Hotels(){
        return $this->belongsTo(Hotels::class, 'hotes_id');
    }
}
