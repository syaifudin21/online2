<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use App\Models\ProfilSiswa;
use Illuminate\Support\Facades\Storage;
use App\Models\Images;
use Validator;
use Session;

class DaftarController extends Controller
{
    public function daftar()
    {
        $tahun = date("Y");
        $tampiltahun = [$tahun, $tahun-1, $tahun-2, $tahun-3, $tahun-5];
        $ta = TahunAjaran::where('status', 'Show')->orderBy('id','DESC')->first();
        if (!$ta) {
            return redirect('/')
            ->with(['alert'=> "'title':'Pendaftaran Masih Ditutup','text':'Terimakasih telah berkunjung', 'icon':'info'"]);

        }
        $jurusans = $ta->ruangKelas()->join('kelas', 'ruang_kelas.id_kelas','=','kelas.id')
                    ->where('kelas.jenis', 'Pertama')
                    ->select('jurusan')
                    ->groupBy('jurusan')
                    ->get();
        return view('front.siswa-daftar', compact('tampiltahun', 'jurusans'));
    }
    public function storedaftar(Request $request)
    {
        $messages = [
            'fotosiswa.max' => 'Kapasitas Foto melebihi batas maksimal, Kapasitas maksimal 2mb',
            'fotosiswa.mimes' => 'Format Foto Harus Jpg/Jpeg/Gif',
            'fotoijazah.max' => 'Kapasitas Ijazah/Bukti Lulus melebihi batas maksimal, Kapasitas maksimal 2mb',
            'fotoijazah.mimes' => 'Format Ijazah/Bukti Lulus Harus Jpg/Jpeg/Gif',
        ];


        $validator = Validator::make($request->all(), [
            'fotosiswa' => 'image|mimes:jpg,png,jpeg|max:2048',
            'fotoijazah' => 'image|mimes:jpg,png,jpeg|max:2048'
        ], $messages);

        if ($validator->fails()) {
            return redirect('daftar')
                        ->withErrors($validator)
                        ->with(['alert'=> "'title':'Gagal Mendaftar','text':'Periksa kembali data inputan anda', 'icon':'error'"])
                        ->withInput();
        }

        $images = new Images();

        $ta = TahunAjaran::where('status', 'Show')->orderBy('id','DESC')->select('id')->first();
        $profil = new ProfilSiswa();
        $profil['id_ta'] = $ta->id;
        $profil['nisn'] = $request->nisn;
        $profil['ttl->tempat'] = $request->tempatlahir;
        $profil['ttl->tgl'] = $request->tanggallahir;
        $profil['nama'] = $request->nama;
        $profil['alamat'] = $request->alamatsiswa;
        $profil['nomor_hp'] = $request->hpsiswa;
        $profil['ayah->nama'] = $request->namaayah;
        $profil['ayah->pekerjaan'] = $request->pekerjaanayah;
        $profil['ayah->pendidikan'] = $request->pendidikanayah;
        $profil['ayah->tempat_lahir'] = $request->tempatlahirayah;
        $profil['ayah->tgl_lahir'] = $request->tanggallahirayah;
        $profil['ayah->ket'] = $request->ketayah;
        $ibu= [
            'nama' => $request->namaibu,
            'pekerjaan' => $request->pekerjaanibu,
            'pendidikan' => $request->pendidikanibu,
            'tempat_lahir' => $request->tempatlahiribu,
            'tgl_lahir' => $request->tanggallahiribu,
            'ket' => $request->ketibu
        ];
        $sekolah =[
            'nama' => $request->sekolah_asal,
            'alamat' => $request->sekolah_alamat,
            'angkatan' => $request->sekolah_angkatan
        ];
        $kettambah = [
            'tinggi' => $request->tinggi,
            'berat' => $request->berat,
            'transportasi' => $request->transportasi,
            'jaraktempu' => $request->jaraktempu,
            'waktutempu' => $request->waktutempu,
        ];
        $pendaftaran = [
            'waktu_daftar' =>  date("Y-m-d H:i:s"),
            'minat_jurusan' => $request->minat
        ];
        $profil['alamat'] = $request->alamat;
        $profil['ibu'] = $ibu;
        $profil['keluarga'] = ['alamat' => $request->alamatortu, 'hportu'=> $request->hportu];
        $profil['sekolah_asal'] = $sekolah;
        $profil['ket_tambahan'] = $kettambah;
        $profil['pendaftaran'] = $pendaftaran;

        $foto = [];
        if ($request->hasFile('fotosiswa')){
            $foto['foto'] = $images->upload($request->file('fotosiswa'), 'siswa/foto');;
        }
        if ($request->hasFile('fotoijazah')){
            $foto['ijazah'] = $images->upload($request->file('fotoijazah'), 'siswa/ijazah');;
        }
        $profil['foto'] = $foto;

        $profil->save();
        $profil->update(['nomor_user'=>$profil->createNoUser($profil->id)]);

        Session::put('nomor_user', $profil->nomor_user);

        return redirect('/cek?nomor='.$profil->nomor_user)
        ->with(['alert'=> "'title':'Selamat','text':'Pendaftaran anda telah kami terima, silahkan melakukan mengkonfirmasi data anda ke sekertariat', 'icon':'success'"]);

    }
    public function cekdaftar()
    {
        $nomor = (!empty($_GET['nomor']))? trim($_GET['nomor']) : '00';
        $profil = ProfilSiswa::where('nomor_user', $nomor)
                    ->where('status','!=','Diterima')
                    ->first();
        return view('front.cek', compact('profil'));
    }
}
