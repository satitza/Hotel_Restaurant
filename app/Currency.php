<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currencies';

    public function Offers() {
        return $this->hasMany(Offers::class);
    }

    public function Reports() {
        return $this->hasMany(Report::class);
    }

}
