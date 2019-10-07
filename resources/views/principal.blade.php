<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de conteo poblacional">
    <meta name="author" content="">
    <meta name="keyword" content="Sistema de conteo poblacional">
    <link rel="shortcut icon" href="">
    <title>Sistema de conteo poblacional</title>
    <meta name ="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js">
    <!-- Icons -->
    <link href="/css/plantilla.css" rel="stylesheet">
    
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <div id = "app">
    <header class="app-header navbar">
        <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="nav navbar-nav d-md-down-none">

        </ul>
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item d-md-down-none">
                <a class="nav-link" href="#" data-toggle="dropdown">
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <span> {{Auth::user()->correo}} </span>
                    <span href="{{ route ('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> Cerrar sesión </span>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </a>

            </li>
        </ul>
    </header>

    <div class="app-body">

        @if(Auth::check())
            @if(Auth::user()->idrol == 1)
                @include('plantilla.sidebarsuperusuario')
            @elseif (Auth::user()->idrol == 2)
                @include('plantilla.sidebarestadista')
            @elseif (Auth::user()->idrol == 3)
                @include('plantilla.sidebardigitador')
            @else 

            @endif    
        @endif
        <!--Aqui se llama al contenido externo-->
        @yield('contenido')
    </div>
    </div>
    

    <footer class="app-footer">
        <span>2019</span>
        
    </footer>
    
    <script src="/js/app.js"></script>
    <script src="/js/plantilla.js"></script>
</body>

</html>