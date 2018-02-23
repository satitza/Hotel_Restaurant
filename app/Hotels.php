<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotels extends Model {

    protected $table = 'hotels';
    
    public function Actives(){
        return $this->belongsTo(Actives::class, 'active_id');
    }

    public function Restaurants() {
        return $this->hasMany(Restaurants::class);
    }
   
}
