<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Siswa extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama', 'username', 'nomor_user', 'password', 'attribut'
    ];
    protected $casc = [
        'attribut' => 'array'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
}
