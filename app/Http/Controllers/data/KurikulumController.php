<?php

namespace App\Http\Controllers\data;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use App\Models\ProfilSiswa;
use DB;

class KurikulumController extends Controller
{
    public function switch()
    {
        $ta = TahunAjaran::find($_GET['id']);
        if ($ta->status == 'Show') {
            $ta->update(['status' => 'Hidden']);
            return 'Hidden';
        }else{
            $ta->update(['status' => 'Show']);
            return 'Show';
        }
    }
    public function absen()
    {
        $profil = ProfilSiswa::where('id', $_GET['id'])->first();
        if ($profil) {
            if ($profil->pendaftaran['hadir_test']== '?' OR $profil->pendaftaran['hadir_test']== 'Absen') {
                $profil = ProfilSiswa::find($_GET['id']);
                $profil['pendaftaran->hadir_test'] = 'Hadir';
                $profil['pendaftaran->waktu_test'] = date('Y-m-d H:i:s');
                $profil->save();
                return response(['data'=> 'Hadir'], 200);
            }else{
                $profil = ProfilSiswa::findOrFail($_GET['id']);
                $profil['pendaftaran->hadir_test'] = 'Absen';
                $profil['pendaftaran->waktu_test'] = '';
                $profil->save();
                return response(['data'=> 'Absen'], 200);
            }
        }else{
            return 500;
        }
    }


}
