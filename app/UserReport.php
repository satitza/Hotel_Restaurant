<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReport extends Model
{
    protected $table = 'user_reports';

    public function User() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Hotels() {
        return $this->belongsTo(Hotels::class, 'hotel_id');
    }
}
