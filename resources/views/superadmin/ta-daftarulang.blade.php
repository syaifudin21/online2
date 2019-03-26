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
            <li class="breadcrumb-item"><a href="{{route('superadmin.ta.show',['id' => $ta->id])}}">{{$ta->tahun_ajaran}}</a></li>
            <li class="breadcrumb-item"><a href="#">Konfirmasi Daftar Ulang</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Daftar Ulang <small>Tahun Ajaran {{$ta->tahun_ajaran}}</small>
                 <div class="btn-group float-right" role="group" aria-label="Basic example">
                                <a class="btn btn-primary mr-1 mb-1 btn-sm" href="{{route('superadmin.ta.show', ['id_ta'=> $ta->id])}}">
                                    <i class="fa fa-arrow-left "></i>Kembali</a> </div>
                </h3>
                <div class="bs-component">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Pendaftar</th>
                                <th>Nama</th>
                                <th>Ttl</th>
                                <th>Sekolah Asal</th>
                                <th class="text-center">L/P</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswas as $nomor => $siswa)

                            <tr>
                                <td class="text-center">{{isset($_GET['page'])? ($nomor+1)+($_GET['page']*10)-10:$nomor+1}}</td>
                                <td>{{$siswa->nomor_user}}</td>
                                <td><b>{{$siswa->nama}}</b></td>
                                <td>{{$siswa->ttl['tempat']}}, {{$siswa->ttl['tgl']}}</td>
                                <td>{{!empty($siswa->sekolah_asal)? $siswa->sekolah_asal['nama']: ''}}</td>
                                <td class="text-center">{{$siswa->jk}}</td>
                                <td>
                                    <div class="toggle-flip">
                                    <label style="display: block; margin-bottom:0px;">
                                        <input type="checkbox"  onchange="daftarulang('{{$siswa->id}}')" {{!empty($siswa->pendaftaran['daftar_ulang']) ? 'checked' : '' }}  ><span class="flip-indecator" data-toggle-on="Sudah" data-toggle-off="Belum"></span>
                                    </label>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$siswas->links('pagination.default')}}
                </div>

            </div>
        </div>

    </div>
</main>

@endsection

@section('script')
<script>
function daftarulang(no) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '{{route('superadmin.ta.dddd.store')}}',
        type: 'POST',
        dataType: "JSON",
        data: {
            'id' : no
        },
        success: function (response) {
            console.log(response)
            if (response.kode = '00') {
                swal({
                    title: "Berhasil",
                    text: "Berhasil Konfirmas Daftar Ulang",
                    icon: "success",
                    timer : 1200,
                    buttons: false
                });
            } else {
                swal("Kesalahan Jaringan, Coba beberapa saat lagi", {
                    icon: "error",
                });
                console.log(response.message);
            }
        },
        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });
}
</script>
@endsection
