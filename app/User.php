<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function ActionLog() {
        return $this->hasMany(ActionLog::class);
    }

    public function UserReport() {
        return $this->hasMany(UserReport::class);
    }

    public function UserEditor() {
        return $this->hasMany(UserEditor::class);
    }

    public function UserRole() {
        return $this->belongsTo(UserRole::class, 'user_role');
    }
}
