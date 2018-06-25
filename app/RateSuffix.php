<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RateSuffix extends Model
{
    protected $table = 'rate_suffixes';

    public function Offers() {
        return $this->hasMany(Offers::class);
    }

    public function Reports() {
        return $this->hasMany(Report::class);
    }
}
