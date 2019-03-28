@extends('superadmin.super-template')
@section('css')

@endsection
@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1>Admin</h1>
            <p>Pembagian Tugas yang dapat diwakilkan oleh staf khusus</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i> Admin</li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Admin
                    <div class="btn-group float-right" role="group" aria-label="Basic example">
                        <a class="btn btn-primary mr-1 mb-1 btn-sm" href="{{route('superadmin.admin.create')}}">
                            <i class="fa fa-plus"></i>Tambah</a> </div>
                </h3>
                <div class="bs-component">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Akses</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $nomor => $admin)
                            <tr>
                                <td>{{$nomor+1}}</td>
                                <td>{{$admin->nama}}</td>
                                <td>{{$admin->username}}</td>
                                <td>
                                    <?php
                                        $arr = $admin->akses;
                                        $status = explode(",",$arr);

                                        $jumlah = count($status);
                                        for ($i=0; $i < $jumlah ; $i++) {
                                            if ($status[$i] == '123456') {echo "<span class='badge badge-primary'>Artikel</span> ";}
                                            elseif ($status[$i] == '211233') {echo "<span class='badge badge-primary'>Pengumuman</span> ";}
                                            elseif ($status[$i] == '981729') {echo "<span class='badge badge-primary'>Album </span> ";}
                                            elseif ($status[$i] == '827980') {echo "<span class='badge badge-primary'>Kelas</span> ";}
                                            elseif ($status[$i] == '981987') {echo "<span class='badge badge-primary'>Agenda </span> ";}
                                            elseif ($status[$i] == '657842') {echo "<span class='badge badge-primary'>Prestasi </span> ";}
                                            elseif ($status[$i] == '912879') {echo "<span class='badge badge-primary'>Masukkan </span>";}
                                            elseif ($status[$i] == '915879') {echo "<span class='badge badge-primary'>Bantuan </span> ";}
                                            elseif ($status[$i] == '962879') {echo "<span class='badge badge-primary'>Forum </span> ";}
                                            elseif ($status[$i] == '812788') {echo "<span class='badge badge-primary'>Perpustakaan </span> ";}
                                            elseif ($status[$i] == '671898') {echo "<span class='badge badge-primary'>Pendaftaran </span> ";}
                                            elseif ($status[$i] == '981098') {echo "<span class='badge badge-primary'> Guru </span> ";}
                                            else{echo "";}
                                        }
                                    ?>
                                </td>
                                <td style="text-align: right">
                                    <a href="{{route('superadmin.admin.edit',['id'=>$admin->id])}}" class="btn btn-default btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="hapus('{{route('superadmin.admin.delete', ['id'=>$admin->id])}}','Apakah anda yakin menghapus Admin {{$admin->nama}}')"><i class="fa fa-exclamation-triangle"></i>Hapus</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

            </div>

        </a>
        </div>

    </div>
</main>

@endsection

@section('script')
<script src="{{asset('js/hapusfunc.js')}}"></script>
@endsection
