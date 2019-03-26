@extends('superadmin.super-template')
@section('css')

@endsection
@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1>Tahun Ajaran  {{$ta->tahun_ajaran}}</h1>
            <p>Informasi jumlah siswa dalam satu periode pembelajaran</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{route('superadmin.ta.home')}}">Tahun Ajaran</a></li>
            <li class="breadcrumb-item"><a href="{{route('superadmin.ta.show',['id' => $ta->id])}}">{{$ta->tahun_ajaran}}</a></li>
            <li class="breadcrumb-item"><a href="#">Pemberian Nilai Siswa</a></li>
        </ul>
    </div>

    <div class="row">
        <?php
            $jmlBelumNilai = $ta->siswaDaftar()->where(['pendaftaran->hadir_test'=>'Hadir', 'pendaftaran->nilai_test'=> '?'])->count();
            $jmlHadir = $ta->siswaDaftar()->where('pendaftaran->hadir_test','Hadir')->count();
            $jmlTidakLolos = $ta->siswaDaftar()->where('status','Tidak Lolos')->count();
            $jmlLolos = $ta->siswaDaftar()->where('status','Diterima')->count();
        ?>
            <div class="col-md-3">
                <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
                <div class="info">
                <a href="{{url()->current().'?filter=belumdinilai'}}"><h4>Belum Dinilai</h4></a>
                    <p><b>{{$jmlBelumNilai}}</b></p>
                </div>
            </div>
            </div>
            <div class="col-md-3">
            <div class="widget-small danger coloured-icon"><i class="icon fa fa-users fa-3x"></i>
                <div class="info">
                <h4>Tidak Lolos</h4>
                <p><b>{{$jmlTidakLolos}}</b></p>
                </div>
            </div>
            </div>

            <div class="col-md-3">
            <div class="widget-small info coloured-icon"><i class="icon fa fa-users fa-3x"></i>
                <div class="info">
                <h4>Diterima</h4>
                <p><b>{{$jmlLolos}}</b></p>
                </div>
            </div>
            </div>

            <div class="col-md-3">
            <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
                <div class="info">
                <a href="{{route('superadmin.ta.tes.nilai',['id'=>$ta->id])}}"><h4>Siswa Hadir</h4></a>
                <p><b>{{$jmlHadir}}</b></p>
                </div>
            </div>
            </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Input Nilai Test Calon Siswa
                    <div class="btn-group float-right" role="group" aria-label="Basic example">
                                <a class="btn btn-primary mr-1 mb-1 btn-sm" href="{{route('superadmin.ta.show', ['id_ta'=> $ta->id])}}"><i class="fa fa-arrow-left "></i>Kembali</a>
                                <a class="btn btn-outline-primary mr-1 mb-1 btn-sm" href="{{route('superadmin.ta.tes.absen', ['id_ta'=> $ta->id])}}">Absen</a>
                    </div>
                </h3>
                <div class="bs-component">
                    <form id="submit-form" method="post" action="{{route('superadmin.ta.tes.store')}}">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Pendaftar</th>
                                <th>Nama</th>
                                <th>Ttl</th>
                                <th>Sekolah Asal</th>
                                <th class="text-center">L/P</th>
                                <th>Nilai</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @csrf
                            @foreach ($siswas as $nomor => $siswa)
                            <tr>
                                <td class="text-center">{{isset($_GET['page'])? ($nomor+1)+($_GET['page']*10)-10:$nomor+1}}</td>
                                <td>{{$siswa->nomor_user}}</td>
                                <td><b>{{$siswa->nama}}</b></td>
                                <td>{{$siswa->ttl['tempat']}}, {{$siswa->ttl['tgl']}}</td>
                                <td>{{!empty($siswa->sekolah_asal)? $siswa->sekolah_asal['nama']: ''}}</td>
                                <td class="text-center">{{$siswa->jk}}</td>
                                <td>
                                    <input type="hidden" name="idsiswa[]" value="{{$siswa->id}}">
                                <input class="form-control form-control-sm" name="nilai[{{$siswa->id}}]" type="number"  min="40" max="100" style="width: 60px" value="{{empty($siswa->pendaftaran['nilai_test'])? '': $siswa->pendaftaran['nilai_test']}}">
                                </td>
                                <td class="text-center">{{empty($siswa->pendaftaran['hasil_test'])? '': $siswa->pendaftaran['hasil_test']}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-md-3">
                                <div class="form-group row">
                                <label class="control-label col-md-8">Nilai Min Kelulusan</label>
                                <div class="col-md-4">
                                    <input class="form-control form-control-sm" id="kkm" name="kkm" type="number" min="40" max="80" placeholder="Nilai" value="{{Session::get('kkm')}}">
                                </div>
                                </div>
                        </div>
                    </div>
                    </form>


					<button class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('submit-form').submit();"><i class="fa fa-fw fa-lg fa-check-circle"></i>Store Nilai</button>

                    <a href="" onclick="event.preventDefault();lock()" class="btn btn-danger">Lok Nilai dan diumumkan ke siswa</a>
                    {{$siswas->links('pagination.default')}}

                </div>

            </div>
        </div>

    </div>
</main>

@endsection

@section('script')
<script>

function lock() {
swal({
        title: "Apakah Kamu Yakin?",
        text: "Kelas akan dikunci",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('superadmin.ta.lock.nilai', ['id'=> $ta->id])}}?kkm="+$("#kkm").val(),
                type: 'POST',
                dataType: "JSON",
                data: {},
                success: function (response) {
                    console.log(response);
                    if (response.kode = '00') {
                        var myVar = setInterval(myTimer, 1200);
                        swal({
                            title: "Berhasil",
                            text: "Berhasil Lock dan mengumumkan ke Calon Siswa",
                            icon: "success",
                            buttons: false
                        });

                        function myTimer() {
                            location.reload();
                        }
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

        } else {
            swal("Batal untuk menghapus item");
        }
    });
}

</script>
@endsection
