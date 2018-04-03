<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookCheckBalance extends Model
{
    protected $table = 'book_check_balances';

    public function Offers(){
        return $this->belongsTo(Offers::class, 'book_offer_id');
    }

    public function Actives(){
        return $this->belongsTo(Actives::class, 'active_id');
    }
}
