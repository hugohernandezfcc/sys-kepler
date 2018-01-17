<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('inspinia/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('inspinia/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{ asset('inspinia/css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset('inspinia/css/style.css')}}" rel="stylesheet">
</head>



<body class="gray-bg">

    <div class="loginColumns animated fadeInDown">
        <div class="row">

            <div class="col-md-6">
                <br/>
                <h2 class="font-bold">Bienvenido a Kepler</h2>

                <p>
                    <b>La plataforma perfecta donde no hay distintivos, todos estamos conectados.</b>
                </p>

                <p>
                    Integra actividades con foros y artículos creados por la comunidad que tu controlas.
                </p>
            </div>
            <div class="col-md-6">
                
                <div class="ibox-content">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input type="email" class="form-control" placeholder="Correo Electrónico" required="">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input type="password" class="form-control" placeholder="Contraseña" required="">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary block full-width m-b">Iniciar sesión</button>

                        <a href="{{ route('password.request') }}">
                            <small>¿Olvidaste tu contraseña?</small>
                        </a>
                        <br/><br/>
                        <p class="text-muted text-center">
                            <small>¿Aun no tienes una cuenta?</small>
                        </p>
                        <a class="btn btn-sm btn-white btn-block" href="{{ route('register') }}">Crear una cuenta</a>
                    </form>
                    <p class="m-t">
                        <small>Kepler systems </small>
                    </p>
                </div>

            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Scripts Menú -->
    <script src="{{ asset('inspinia/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('inspinia/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('inspinia/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('inspinia/js/inspinia.js') }}"></script>
    <script src="{{ asset('inspinia/js/plugins/pace/pace.min.js') }}"></script>
</body>


