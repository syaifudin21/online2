<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{asset(env('APP_LOGO'))}}">

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style type="text/css">
        .material-icons {
            align-items: center;
            display: flex;
            justify-content: center;
        }

    </style>
</head>

<body style="background-color: white">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <b>{{env('SEKOLAH_NAMA')}}</b>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->

                <form action="{{url('/cek')}}" class="form-inline my-2 my-lg-0">
                    <div class="input-group" style="width: 600px">
                        <input type="text" name="nomor" class="form-control" placeholder="Masukkan nomor Pendaftaran anda disini" aria-label="Input group example"
                            aria-describedby="btnGroupAddon2" value="{{(empty($_GET['nisn']))? '': $_GET['nisn']}}">
                    </div>
                </form>
            </div>
        </div>
    </nav>
    <br>


    <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Full Calendar Example</div>

                <div class="panel-body">
                    {!! $calendar->calendar() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>

{!! $calendar->script() !!}

@if(Session::has('alert'))
<script src="{{asset('js/sweetalert.min.js')}}"></script>
<script>
    swal({
      {!!Session::get('alert')!!}
    });
</script>
@endif
</body>
</html>
