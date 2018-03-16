<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserEditor extends Model
{
    protected $table = 'user_editors';

    /*protected $casts = [
        'restaurant_id' => 'json',
    ];*/

    public function User() {
        return $this->belongsTo(User::class, 'user_id');
    }

}
