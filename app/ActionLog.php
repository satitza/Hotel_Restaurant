<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionLog extends Model
{
    protected  $table = 'action_logs';

    public function Users() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
