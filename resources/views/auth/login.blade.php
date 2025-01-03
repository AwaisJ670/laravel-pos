<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Login</title>

    {{--    Favicon--}}
    {{-- <link rel="icon" href="{{ asset('images/logo.ico') }}"> --}}

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome-free/css/all.min.css') }}">
    {{-- Theme css --}}
    {{-- <link rel="stylesheet" href="{{ mix('css/theme.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css')}}">
    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

</head>
    <body class="hold-transition login-page">
    <div class="login-box" style="width: 60%">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="login-logo mb-5 mt-3">
                    <a href="{{route('login-page')}}">
                        {{-- <img src="{{asset('images/logo.png')}}" alt="logo-image" width="100"> --}}
                    </a>
                </div>
            </div>
        </div>
        <div style="background-color: #E9ECEF">
            <div class="row" style="height: 24rem">
                <div class="col-lg-6 col-md-6 d-none d-xl-block d-lg-block d-md-block">
                    <div class="login-image">
                        <img class="img-fluid" src="{{asset('images/undraw_stand_out_1oag.png')}}"
                             width="500">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="login-form">
                        <p class="login-box-msg text-bold">Login</p>

                        @if($errors->all())
                            <div class="alert alert-danger">{{$errors->first()}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if(session()->has('message'))
                            <div class="alert alert-success">{{ session()->get('message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <form role="form" method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="input-group mb-3">
                                <input type="email" class="form-control" placeholder="Email" name="email" autofocus
                                       tabindex="1">
                                <div class="input-group-append">
                                    <div class="input-group-text bg-white">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" placeholder="Password" name="password"
                                       autocomplete="password" tabindex="2">
                                <div class="input-group-append">
                                    <div class="input-group-text bg-white">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <button type="submit" class="btn bg-gradient-primary btn-sm mt-2" style="width: 100px"
                                            tabindex="3">Sign In</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- jQuery --}}
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    {{-- Theme js --}}
    {{-- <script src="{{ mix('js/theme.js') }}"></script> --}}

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/adminlte.min.js') }}"></script>
    {{-- custom js--}}
    <script src="{{asset('js/custom.js')}}"></script>
</body>
</html>
