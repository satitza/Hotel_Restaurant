<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookCheckBalance extends Model
{
    protected $table = 'book_check_balances';

    public function SetMenu(){
        return $this->belongsTo(SetMenu::class, 'book_menu_id');
    }

    public function Actives(){
        return $this->belongsTo(Actives::class, 'active_id');
    }
}
