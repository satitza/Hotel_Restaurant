<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    protected $table = 'images';

    public function Offers()
    {
        return $this->belongsTo(Offers::class, 'offer_id');
    }
}
