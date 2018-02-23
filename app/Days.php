<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Days extends Model
{
    protected $table = 'days';
    
    public function SetMenu() {
        return $this->hasMany(SetMenu::class);
    }
}
