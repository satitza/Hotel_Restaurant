<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actives extends Model {

    protected $table = 'actives';

    public function Hotels() {
        return $this->hasMany(Hotels::class);
    }

    public function Restaurants() {
        return $this->hasMany(Restaurants::class);
    }

    public function Offers() {
        return $this->hasMany(Offers::class);
    }

    public function BookCheckBalance(){
        return $this->hasMany(BookCheckBalance::class);
    }

}
