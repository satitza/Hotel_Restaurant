<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actives extends Model {

    protected $table = 'actives';

    public function Hotels() {
        return $this->hasMany(Restaurants::class);
    }

    public function Restaurants() {
        return $this->hasMany(Restaurants::class);
    }

}
