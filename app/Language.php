<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'languages';

    public function SetMenu() {
        return $this->hasMany(SetMenu::class);
    }
}