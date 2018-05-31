<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Termsth extends Model
{
    protected $table = 'termsths';

    public function Offers()
    {
        return $this->belongsTo(Offers::class, 'offer_id');
    }
}
