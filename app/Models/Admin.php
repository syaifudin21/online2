<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'username', 'nomor_user', 'password', 'coba'
    ];
    protected $casts = [
        'id' => 'int',
        'coba' => 'array'
   ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
