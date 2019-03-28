<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama', 'username', 'password', 'akses'
    ];
    protected $casts = [
        'id' => 'int',
        'akses' => 'array'
   ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
