<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotels extends Model {

    protected $table = 'hotels';

    public function UserReport() {
        return $this->hasMany(UserReport::class);
    }
    
    public function Actives(){
        return $this->belongsTo(Actives::class, 'active_id');
    }

    public function Restaurants() {
        return $this->hasMany(Restaurants::class);
    }
    
    public function SetMenu() {
        return $this->hasMany(SetMenu::class);
    }
   
}
