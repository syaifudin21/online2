@extends('superadmin.super-template')
@section('css')

@endsection
@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1>Tahun Ajaran</h1>
            <p>Informasi jumlah siswa dalam satu periode pembelajaran</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{route('superadmin.ta.home')}}">Tahun Ajaran</a></li>
            <li class="breadcrumb-item"><a href="#">{{$ta->tahun_ajaran}}</a></li>
        </ul>
    </div>

    <div class="row">
            <div class="col-md-3">
            <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
                <div class="info">
                    <h4>Pendaftar</h4>
                    <p><b>{{$ta->siswaDaftar()->count()}}</b></p>
                </div>
            </div>
            </div>
            <div class="col-md-3">
            <div class="widget-small danger coloured-icon"><i class="icon fa fa-users fa-3x"></i>
                <div class="info">
                <h4>Tidak Lolos</h4>
                <p><b>{{$ta->siswaDaftar()->where('status','Tidak Lolos')->count()}}</b></p>
                </div>
            </div>
            </div>

            <div class="col-md-3">
            <div class="widget-small info coloured-icon"><i class="icon fa fa-users fa-3x"></i>
                <div class="info">
                <h4>Daftar Ulang</h4>
                <p><b>{{$ta->siswaDaftar()->where('status','Verifikasi Admin')->where('pendaftaran->daftar_ulang', '!=', '?')->count()}}</b></p>
                </div>
            </div>
            </div>

            <div class="col-md-3">
            <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
                <div class="info">
                <h4>Siswa Aktif</h4>
                <p><b>{{$ta->siswaDaftar()->where('status','Diterima')->whereRaw('JSON_EXTRACT(pendaftaran, "$.daftar_ulang") is not null')->count()}}</b></p>
                </div>
            </div>
            </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="tile">
                <h3 class="tile-title">Tahun Ajaran {{$ta->tahun_ajaran}}

                    <div class="btn-group float-right" role="group" aria-label="Basic example">
                        <a class="btn btn-primary mr-1 mb-1 btn-sm" href="{{route('superadmin.rk.create', ['id_ta'=> $ta->id])}}">
                            <i class="fa fa-plus"></i>Tambah</a> </div>
                </h3>
                <div class="bs-component">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Ruang Kelas</th>
                                <th class="text-center">Jurusan</th>
                                <th>Tingkat Kelas</th>
                                <th class="text-center">Siswa</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ta->ruangKelas()->orderBy('id_kelas', 'ASC')->get() as $rk)
                            <tr>
                                <td><b>{{$rk->ruang_kelas}}</b></td>
                                <td class="text-center">{{$rk->jurusan}}</td>
                                <td>{{$rk->kelas->kelas}} <small>({{$rk->kelas->jenis}})</small></td>
                                <td class="text-center">{{$rk->struktur->count()}}</td>
                                <td class="text-center">
                                    <a class="card-link" href="{{route('superadmin.rk.show', ['id'=> $rk->id])}}">Detail</a>
                                    <a class="card-link" href="{{route('superadmin.rk.edit', ['id'=>$rk->id])}}">Edit</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

            </div>

            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="tile">
                        <h3 class="tile-title">Calon Siswa</h3>
                        <div class="tile-body row">
                            <div class="col-sm-8"> Daftar calon siswa, untuk konfirmasi pendaftaran silahkan masuk disini</div>
                            <div class="col-sm-4">
                                    <i class="icon fa fa-users fa-3x"></i>
                            </div>
                        </div>
                        <hr style="margin: 10px">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="btn-group float-right btn-group-sm">
                                    <a class="btn btn-secondary float-right" href="{{route('superadmin.ta.siswa',['id'=>$ta->id])}}">Verifikasi Calon Siswa</a>
                                    <a class="btn btn-primary" href="{{route('superadmin.ta.daftarulang',['id'=>$ta->id])}}">Daftar Ulang</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                        <div class="tile">
                            <h3 class="tile-title">Test Masuk Calon Siswa</h3>
                            <div class="tile-body row">
                                <div class="col-sm-8">
                                    Absen calon siswa dan input nilai tes. Memberitahukan nilai pada calon siswa
                                </div>
                                <div class="col-sm-4">
                                        <i class="icon fa fa-hand-paper-o fa-3x"></i>
                                </div>
                            </div>
                            <hr style="margin: 10px">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="btn-group float-right btn-group-sm">
                                            <a class="btn btn-secondary" href="{{route('superadmin.ta.tes.absen',['id'=>$ta->id])}}">Absen Calon Siswa</a>
                                            <a class="btn btn-success" href="{{route('superadmin.ta.tes.nilai',['id'=>$ta->id])}}">Input Nilai Siswa</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="row">

                <div class="col-sm-12">
                    <div class="tile">
                        <h3 class="tile-title">Manentukan Kelas</h3>
                        <div class="tile-body">Siswa Baru yang telah melakukan daftar ulang dapat ditempatkan pada kelas. Siswa daftar terlamat dan transfer sekolah lain dapat dilakukan disini</div>
                        <hr style="margin: 10px">
                        <div class="row">
                                <div class="col-sm-12 btn-group float-right btn-group-sm">
                                        <a class="btn btn-secondary" href="{{route('superadmin.ta.tempatkan',['id'=>$ta->id])}}">Tempatkan Siswa Siswa</a>
                                        <a class="btn btn-secondary" href="{{route('superadmin.ta.tempatkan',['id'=>$ta->id])}}">Tempatkan Siswa Telat Masuk Tahun Pertama</a>
                                        <a class="btn btn-secondary" href="{{route('superadmin.ta.tempatkan',['id'=>$ta->id])}}" disabled>Tempatkan Siswa Transfer Nilai</a>


                                </div>
                        </div>
                    </div>
                </div>
            </div>

        </a>
        </div>

        <div class="col-md-4">
            <div class="tile">
                <h3 class="tile-title">{{$ta->tahun_ajaran}}
                        <div class="btn-group float-right">
                                <a href="{{env('FTP_BASE').$ta->jadwal}}" class="btn btn-outline-secondary btn-sm">Jadwal</a>
                                <a href="{{env('FTP_BASE').$ta->brosur}}" class="btn btn-outline-secondary btn-sm">Brosur</a>
                        </div>
                </h3>
                <hr>
                <div class="bs-component">
                    <b>Rencana Tanggal Pendaftaran</b><br>
                    {{hari_tanggal($ta->tgl_pendaftaran, true)}} <hr>

                    <b>Tanggal Test</b> <br>
                    {{hari_tanggal($ta->tgl_test, true)}} <hr>
                    <b>Tanggal Pengumuman</b><br>
                    {{hari_tanggal($ta->tgl_pengumuman, true)}} <hr>
                    <b>Tanggal Daftar Ulang</b><br>
                    {{hari_tanggal($ta->tgl_daftar_ulang, true)}} <hr>



                    <dl class="row">
                        <dd class="col-sm-8">Rubah Status ke Show sebagai penanda pendaftaran dibuka</dd>
                        <dd class="col-sm-4">
                            <div class="toggle-flip">
                            <label>
                                <input type="checkbox"  onchange="statusta('{{$ta->id}}')" {{($ta->status == 'Show')? 'checked' : '' }}  ><span class="flip-indecator" data-toggle-on="Show" data-toggle-off="Hidden"></span>
                            </label>
                            </div>
                        </dd>
                    </dl><hr>
                    <a class="btn btn-outline-secondary btn-sm" href="{{route('superadmin.ta.edit', ['id'=>$ta->id])}}"><i class="fa fa-pencil-square-o"></i>Edit</a>

                    <button type="button" class="btn btn-outline-danger btn-sm float-right" id="hapus" data-url="{{route('superadmin.ta.delete', ['id'=>$ta->id])}}"
                            data-redirect="{{ route('superadmin.ta.home')}}" data-pesan="Apakah anda yakin ingin menghapus {{$ta->tahun_ajaran}}"><i class="fa fa-exclamation-triangle"></i>Hapus</button>

                </div>
            </div>

        </div>
    </div>
</main>

@endsection

@section('script')
<script src="{{asset('js/hapus.js')}}"></script>
<script>
    function statusta(no) {
        $.get('{{ route('data.ta.switch')}}?id='+no);
    }
</script>
@endsection
