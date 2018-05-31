<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Termscn extends Model
{
    protected $table = 'termscns';

    public function Offers()
    {
        return $this->belongsTo(Offers::class, 'offer_id');
    }
}
