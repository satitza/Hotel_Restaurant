<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    public function Hotels() {
        return $this->hasMany(Hotels::class);
    }
}
