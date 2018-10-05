<nav class="navbar navbar-expand-lg navbar-dark  fixed-top" style="background-color: #000">
    <a class="navbar-brand" href="#">
        <img src="{{ URL::asset('img/logo.png') }}" width="120" height="30" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
                   
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Cliente
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ URL::asset('/alta_cliente') }}">Registrar Cliente Nuevo</a>
                    {{-- <a class="dropdown-item" href="{{ URL::asset('consulta_cliente') }}">Consulta Clientes</a> --}}

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="{{ URL::asset('/consultar_clientes') }}">Consultar Clientes</a>                    
                    <div class="dropdown-divider"></div>
                    {{-- <a class="dropdown-item" href="{{ URL::asset('/consulta1') }}">Consultar Actividad Labor de Venta</a> --}}
                    {{-- <a class="dropdown-item" href="{{ URL::asset('/consultar_bitacora') }}">Bitacora Labor de Venta</a> --}}
                </div >
            </li>
             <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Labor de Venta
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ URL::asset('/consulta1') }}">Consultar Actividad Labor de Venta</a>
                     <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ URL::asset('/con_bitacora') }}">Bitacora Labor de Venta</a>
                </div >
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Usuario
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ URL::asset('/alta_user') }}">Alta y consulta de usuarios</a>
                </div >
            </li>
           
        </ul>
        
        <ul class="navbar-nav ">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ Session::get('usuario') }}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ URL::asset('/salir') }}">Cerrar Sesión</a>
                </div >
            </li>
        </ul>
    </div>
</nav>