<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $fillable = [
        'nomor_user','title','start_date','end_date','kegiatan', 'deskripsi','lampiran'
    ];
    protected $cascs =[
        'deskripsi' => 'array'
    ];
}
