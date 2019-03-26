<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $fillable = [
        'tahun_ajaran','tgl_pendaftaran','tgl_test','tgl_pengumuman','tgl_daftar_ulang','jadwal','brosur','status'
    ];
    protected $casts = [
        'tgl_pendaftaran' => 'date',
        'tgl_test' => 'date',
        'tgl_pengumuman' => 'date',
        'tgl_daftar_ulang' => 'date'
    ];
    public function ruangKelas()
    {
        return $this->hasMany(RuangKelas::class, 'id_ta', 'id');
    }
    public function siswaDaftar()
    {
        return $this->hasMany(ProfilSiswa::class, 'id_ta', 'id');
    }
}
