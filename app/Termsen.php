<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Termsen extends Model
{
    protected $table = 'termsens';

    public function Offers()
    {
        return $this->belongsTo(Offers::class, 'offer_id');
    }
}
