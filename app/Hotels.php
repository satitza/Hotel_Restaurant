<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotels extends Model {

    protected $table = 'hotels';

    public function Restaurants() {
        return $this->hasMany(Restaurants::class);
    }

}
