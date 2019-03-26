<?php

namespace App\Http\Controllers\superadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Storage;
use App\Models\Kelas;
use App\Models\ProfilSiswa;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;
use App\Models\RuangKelas;
use App\Models\StrukturRuangKelas;
use DB;
use Session;

class TahunAjaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:superadmin');
    }
    public function index()
    {
        $tas = TahunAjaran::orderBy('status','AsC')->paginate(3);
    	return view('superadmin.ta', compact('tas'));
    }
    public function create()
    {
        return view('superadmin.ta-tambah');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'tahun_ajaran' => 'required|string|max:255',
            'jadwal' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'brosur' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);

        $ta = new TahunAjaran();
        $ta->fill($request->all());
        if ($request->hasFile('jadwal')){
            $filenamewithextension = $request->file('jadwal')->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $extension = $request->file('jadwal')->getClientOriginalExtension();
            $filenametostorefoto = $filename.'_'.uniqid().'.'.$extension;
            Storage::disk('ftp')->put(env('APP_ENV').'/ta/'.$filenametostorefoto, fopen($request->file('jadwal'), 'r+'));
            $ta['jadwal'] = env('APP_ENV').'/ta/'.$filenametostorefoto;
        }
        if ($request->hasFile('brosur')){
            $filenamewithextension = $request->file('brosur')->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $extension = $request->file('brosur')->getClientOriginalExtension();
            $filenametostorefoto = $filename.'_'.uniqid().'.'.$extension;
            Storage::disk('ftp')->put(env('APP_ENV').'/ta/'.$filenametostorefoto, fopen($request->file('brosur'), 'r+'));
            $ta['brosur'] = env('APP_ENV').'/ta/'.$filenametostorefoto;
        }
        $ta->save();

        if($ta){
            return redirect(route('superadmin.ta.home'))
            ->with(['alert'=> "'title':'Berhasil','text':'Data Berhasil Disimpan', 'icon':'success','buttons': false, 'timer': 1200"]);
        }else{
            return back()
            ->with(['alert'=> "'title':'Gagal Menyimpan','text':'Data gagal disimpan, periksa kembali data inputan', 'icon':'error'"])
            ->withInput($request->all());
        }
    }
    public function edit($id_ta)
    {
        $ta = TahunAjaran::findOrFail($id_ta);
        return view('superadmin.ta-edit', compact('ta'));
    }
    public function update(Request $request)
    {
        $this->validate($request, [
            'tahun_ajaran' => 'required|string|max:255',
            'jadwal' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'brosur' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);

        $ta = TahunAjaran::findOrFail($request->id);
        $ta->fill($request->all());
        if ($request->hasFile('jadwal')){
            $filenamewithextension = $request->file('jadwal')->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $extension = $request->file('jadwal')->getClientOriginalExtension();
            $filenametostorefoto = $filename.'_'.uniqid().'.'.$extension;
            Storage::disk('ftp')->put(env('APP_ENV').'/ta/'.$filenametostorefoto, fopen($request->file('jadwal'), 'r+'));
            $ta['jadwal'] = env('APP_ENV').'/ta/'.$filenametostorefoto;
        }
        if ($request->hasFile('brosur')){
            $filenamewithextension = $request->file('brosur')->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $extension = $request->file('brosur')->getClientOriginalExtension();
            $filenametostorefoto = $filename.'_'.uniqid().'.'.$extension;
            Storage::disk('ftp')->put(env('APP_ENV').'/ta/'.$filenametostorefoto, fopen($request->file('brosur'), 'r+'));
            $ta['brosur'] = env('APP_ENV').'/ta/'.$filenametostorefoto;
        }
        $ta->save();

        if($ta){
            return redirect(route('superadmin.ta.show', ['id'=> $ta->id]))
            ->with(['alert'=> "'title':'Berhasil','text':'Data Berhasil Disimpan', 'icon':'success','buttons': false, 'timer': 1200"]);
        }else{
            return back()
            ->with(['alert'=> "'title':'Gagal Menyimpan','text':'Data gagal disimpan, periksa kembali data inputan', 'icon':'error'"])
            ->withInput($request->all());
        }
    }
    public function show($id)
    {
        $ta = TahunAjaran::findOrFail($id);
        return view('superadmin.ta-id', compact('ta'));
    }
    public function delete($id)
    {
        $ta = TahunAjaran::findOrFail($id);
        if (!empty($ta)) {
            $ta->ruangkelas()->delete();
            $ta->delete();
            return response()->json(['kode'=>'00'], 200);
        }else{
            return response()->json(['kode'=>'01'], 200);
        }
    }
    public function taSiswa($id)
    {
        $ta = TahunAjaran::findOrFail($id);
        $siswas = $ta->siswaDaftar()->orderBy('nomor_user', 'ASC')->paginate(10);
        return view('superadmin.ta-siswa', compact('ta', 'siswas'));
    }
    public function absenSiswa($id)
    {
        $ta = TahunAjaran::findOrFail($id);
        $siswas = $ta->siswaDaftar()->orderBy('nomor_user', 'ASC')
                ->where('status', '!=' , 'Daftar')
                ->paginate(10);
        return view('superadmin.ta-absen', compact('ta', 'siswas'));
    }
    public function belumAbsenSiswa($id)
    {
        $ta = TahunAjaran::findOrFail($id);
        $siswas = $ta->siswaDaftar()->orderBy('nomor_user', 'ASC')
                ->where('status', '!=' , 'Daftar')
                ->where('pendaftaran->hadir_test','?')
                ->paginate(10);
        return view('superadmin.ta-absen', compact('ta', 'siswas'));
    }
    public function hadirSiswaTest($id)
    {
        $ta = TahunAjaran::findOrFail($id);
        $siswas = $ta->siswaDaftar()->orderBy('nomor_user', 'ASC')
                ->where('status', '!=' , 'Daftar')
                ->where('pendaftaran->hadir_test', 'Hadir')
                ->paginate(10);
        return view('superadmin.ta-absen', compact('ta', 'siswas'));
    }
    public function absenSiswaTest($id)
    {
        $ta = TahunAjaran::findOrFail($id);
        $siswas = $ta->siswaDaftar()->orderBy('nomor_user', 'ASC')
                ->where('status', '!=' , 'Daftar')
                ->where('pendaftaran->hadir_test', 'Absen')
                ->paginate(10);
        return view('superadmin.ta-absen', compact('ta', 'siswas'));
    }

    public function nilaiSiswa($id)
    {
        $ta = TahunAjaran::findOrFail($id);
        $siswas = $ta->siswaDaftar()->orderBy('nomor_user', 'ASC')
                ->Where('pendaftaran->hadir_test', 'Hadir')
                ->paginate(10);
        if (!empty($_GET['filter'])) {
            if ($_GET['filter'] == 'belumdinilai') {
                $siswas = $ta->siswaDaftar()->orderBy('nomor_user', 'ASC')
                            ->Where('pendaftaran->hadir_test', 'Hadir')
                            ->where('pendaftaran->nilai_test',' ?')->paginate(10);
            }
        }
        return view('superadmin.ta-nilai', compact('ta', 'siswas'));
    }
    public function nilaiStore(Request $request)
    {
        foreach ($request->idsiswa as $siswa) {
            if ($request->nilai[$siswa] != null) {
                $profil = ProfilSiswa::find($siswa);
                $profil['pendaftaran->nilai_test'] = $request->nilai[$siswa];
                if ($request->nilai[$siswa] >= $request->kkm) {
                    $profil['pendaftaran->hasil_test'] = 'Lolos Tes';
                }else{
                    $profil['pendaftaran->hasil_test'] =  'Tidak Lolos Tes';
                }
                $profil->save();
            }
        }
        Session::put('kkm', $request->kkm);
        return back()
        ->with(['alert'=> "'title':'Berhasil','text':'Nilai Berhasil Disimpan', 'icon':'success','buttons': false, 'timer': 1200"]);
    }
    public function loknilai($idta)
    {
        $ta = TahunAjaran::findOrFail($idta);
        $siswas = $ta->siswaDaftar()->orderBy('nomor_user', 'ASC')
                ->where('pendaftaran->hadir_test', 'Hadir')
                ->get();

        $ta->siswaDaftar()->orderBy('nomor_user', 'ASC')
                ->where('pendaftaran->hadir_test', 'Absen')
                ->where('status', 'Verifikasi Admin')
                ->update(['status'=> 'Tidak Lolos']);

        foreach ($siswas as $siswa) {
            if (!empty($siswa->pendaftaran['nilai_test'])) {
                $profil = ProfilSiswa::find($siswa->id);
                if ($siswa->pendaftaran['nilai_test'] >= $_GET['kkm']) {
                    $profil['pendaftaran->hasil_test'] = 'Lolos Tes';
                    $profil['status'] = 'Diterima';
                }else{
                    $profil['pendaftaran->hasil_test'] =  'Tidak Lolos Tes';
                    $profil['status'] = 'Tidak Lolos';
                }
                $profil->save();
            }
        }
        Session::put('kkm', $_GET['kkm']);
        return response(['kode' => '00'],200);
    }
    public function daftarUlang($idta)
    {
        $ta = TahunAjaran::findOrFail($idta);
        $siswas = $ta->siswaDaftar()->orderBy('nomor_user', 'ASC')
                ->Where('status', 'Diterima')
                ->paginate(20);
        return view('superadmin.ta-daftarulang', compact('ta', 'siswas'));
    }
    public function storeDaftarUlang(Request $request)
    {
        $siswa = ProfilSiswa::find($request->id);
        $find = Siswa::where('nomor_user', $siswa->nomor_user)->first();
        if (!empty($siswa->pendaftaran['daftar_ulang'])) {
            $siswa['pendaftaran->daftar_ulang'] = '';
            $find->delete();
        }else{
            $siswa['pendaftaran->daftar_ulang'] = date("Y-m-d H:i:s");
        }
        $siswa->save();
        if ($siswa) {
            if (empty($find)) {
                $user = new Siswa();
                $user['nama'] = $siswa->nama;
                $user['username'] = $siswa->nomor_user;
                $user['nomor_user'] = $siswa->nomor_user;
                $user['password'] = Hash::make($siswa->nisn);
                $user->save();
            }
            return response()->json(['kode' => '00'], 200);
        }else{
            return response()->json(['kode' => '01'], 400);

        }
    }
    public function tempatkan($idta)
    {
        $ta = TahunAjaran::findOrFail($idta);
        $siswas = $ta->siswaDaftar()->orderBy('profil_siswas.nomor_user', 'ASC')
                ->where('pendaftaran->daftar_ulang','!=', '?')
                ->where('pendaftaran->tgl_diterima','=', '?')
                ->Where('profil_siswas.status', 'Diterima')
                // ->join('struktur_ruang_kelas','profil_siswas.nomor_user','=', 'struktur_ruang_kelas.nomor_user' )
                // ->where('struktur_ruang_kelas.status', '!=', 'Aktif')
                // ->where('jabatan', 'Siswa')
                ->paginate(20);
        $kelass = $ta->ruangKelas()->join('kelas', 'ruang_kelas.id_kelas','=','kelas.id')
                ->where('kelas.jenis', 'Pertama')
                ->select('ruang_kelas','jurusan', 'ruang_kelas.id as id')
                ->get();
        return view('superadmin.ta-tempatkan', compact('ta', 'siswas', 'kelass'));
    }
    public function tempatkanstore(Request $request)
    {
        $nomoruser = $request->nomor_user;
        $kelassek = $request->kelassek;
        $srks = StrukturRuangKelas::where(['nomor_user'=>$nomoruser]);
        if ($srks->count() > 0) {
            $srkb = $srks->first();
            $srkb['id_rk'] = $kelassek;
            $srkb['nomor_user'] = $nomoruser;
            $srkb['jabatan'] = 'Siswa';
            $srkb['status'] = 'Daftar';
            $srkb->save();

            $jml = StrukturRuangKelas::groupBy('id_rk')->select(DB::raw('count(*) as jumlah'), 'id_rk')->get();
        }else{
            $srkb = new StrukturRuangKelas();
            $srkb['id_rk'] = $kelassek;
            $srkb['nomor_user'] = $nomoruser;
            $srkb['jabatan'] = 'Siswa';
            $srkb['status'] = 'Daftar';
            $srkb->save();

            $jml = StrukturRuangKelas::groupBy('id_rk')->select(DB::raw('count(*) as jumlah'), 'id_rk')->get();
        };
        return response()->json(['jml'=> $jml], 200);
    }
    public function lockkelas(Request $request)
    {
        $ta = TahunAjaran::findOrFail($request->id_ta);
        $kelass = $ta->ruangKelas()->join('kelas', 'ruang_kelas.id_kelas','=','kelas.id')
                ->where('kelas.jenis', 'Pertama')
                ->select('ruang_kelas','jurusan', 'ruang_kelas.id as id')
                ->get();
        $ta->siswaDaftar()->orderBy('profil_siswas.nomor_user', 'ASC')
                ->where('pendaftaran->daftar_ulang','!=', '?')
                ->Where('profil_siswas.status', 'Diterima')
                ->update(['pendaftaran->tgl_diterima'=> date('Y-m-d')]);
        foreach ($kelass as $kelas) {
            StrukturRuangKelas::where('id_rk',$kelas->id)->update(['status'=> 'Aktif']);
        }
        return response()->json(['kode' => '00'], 200);
    }

}
