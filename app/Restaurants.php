<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurants extends Model
{
    protected $table = 'restaurants';
    
    public function SetMenu() {
        return $this->hasMany(SetMenu::class);
    }
       
    public function Hotels(){
        return $this->belongsTo(Hotels::class, 'hotes_id');
    }
    
    public function Actives(){
        return $this->belongsTo(Actives::class, 'active_id');
    }
}
