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
            <div class="col-md-8">
                <div class="tile">
                  <div class="tile-body">
                    <form class="form-horizontal" id="submit-form" method="post" action="{{route('superadmin.admin.update')}}">
                        {{ csrf_field() }} @method('put')

                    <input type="hidden" name="id" value="{{$admin->id}}">

                      <div class="form-group row">
                        <label class="control-label col-md-4" for="nama">Nama</label>
                        <div class="col-md-7">
                            <input class="form-control {{ $errors->has('nama') ? ' is-invalid' : '' }}" type="text" name="nama" placeholder="Nama" value="{{$admin->nama}}" aria-describedby="nama" id="nama">
                            @if ($errors->has('nama'))
                                <small class="form-text text-muted" id="bab">{{ $errors->first('nama') }}</small>
                            @endif
                        </div>
                      </div>
                        <div class="form-group row">
                        <label class="control-label col-md-4" for="username">Username</label>
                        <div class="col-md-7">
                            <input class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" type="text" name="username" placeholder="username" value="{{$admin->username}}" aria-describedby="username" id="username">
                            @if ($errors->has('username'))
                                <small class="form-text text-muted" id="bab">{{ $errors->first('username') }}</small>
                            @endif
                        </div>
                      </div>

                      <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label">{{ __('Password') }}</label>

                            <div class="col-md-7">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Ketik Password" required>

                                @if ($errors->has('password'))
                                    <small class="form-text text-muted" id="bab">{{ $errors->first('password') }}</small>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label">{{ __('Confirm Password') }}</label>

                            <div class="col-md-7">
                                <input id="password-confirm" type="password" class="form-control" placeholder="Ketik Ulang Password" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label">{{ __('Akses') }}</label>

                            <div class="col-md-7">
                                            <div class="form-check">
                                              <input class="form-check-input" type="checkbox" name="akses[]" id="kelas" value="827980" {{(preg_match("/827980/i", $admin->akses))?'checked': ''}}>
                                              <label class="form-check-label" for="kelas">
                                                Kelas
                                              </label>
                                            </div>
                                            <div class="form-check">
                                              <input class="form-check-input" type="checkbox" name="akses[]" id="agenda" value="981987" {{(preg_match("/981987/i", $admin->akses))?'checked': ''}}>
                                              <label class="form-check-label" for="agenda">
                                                Agenda
                                              </label>
                                            </div>
                                            <div class="form-check">
                                              <input class="form-check-input" type="checkbox" name="akses[]" id="bantuan" value="915879" {{(preg_match("/915879/i", $admin->akses))?'checked': ''}}>
                                              <label class="form-check-label" for="bantuan">
                                                Bantuan
                                              </label>
                                            </div>
                                            <div class="form-check">
                                              <input class="form-check-input" type="checkbox" name="akses[]" id="pengajar" value="981098" {{(preg_match("/981098/i", $admin->akses))?'checked': ''}}>
                                              <label class="form-check-label" for="pengajar">
                                                Pengajar / Guru
                                              </label>
                                            </div>
                                            <div class="form-check">
                                              <input class="form-check-input" type="checkbox" name="akses[]" id="prestasi" value="657842" {{(preg_match("/657842/i", $admin->akses))?'checked': ''}}>
                                              <label class="form-check-label" for="prestasi">
                                                Prestasi
                                              </label>
                                            </div>
                                            <div class="form-check">
                                              <input class="form-check-input" type="checkbox" name="akses[]" id="masukan" value="912879" {{(preg_match("/912879/i", $admin->akses))?'checked': ''}}>
                                              <label class="form-check-label" for="masukan">
                                                Masukkan
                                              </label>
                                            </div>
                                            <div class="form-check">
                                              <input class="form-check-input" type="checkbox" name="akses[]" id="forum" value="962879" {{(preg_match("/962879/i", $admin->akses))?'checked': ''}}>
                                              <label class="form-check-label" for="forum">
                                                Forum
                                              </label>
                                            </div>
                                             <div class="form-check">
                                              <input class="form-check-input" type="checkbox" name="akses[]" id="perpustakaan" value="812788" {{(preg_match("/812788/i", $admin->akses))?'checked': ''}}>
                                              <label class="form-check-label" for="perpustakaan">
                                                Perpustakaan
                                              </label>
                                            </div>
                            </div>
                        </div>



                        <input type="hidden" name="redirect" value="{{url()->previous()}}">
                    </form>

                  </div>
                  <div class="tile-footer">
                    <div class="row">
                      <div class="col-md-8 col-md-offset-3">
                        <button class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('submit-form').submit();"><i class="fa fa-fw fa-lg fa-check-circle"></i>Edit</button>
                        <a class="btn btn-secondary" href="{{url()->previous()}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Batal</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

</main>

@endsection

@section('script')
@endsection
