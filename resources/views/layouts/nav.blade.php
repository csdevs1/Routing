@if(Auth::check())
<nav class="navbar navbar-toggleable-sm navbar-light navbar-info">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="ion-navicon-round"></span>
        </button>
        <a class="navbar-brand" href="{{ url('/') }}"><img class="img-responsive logo-small" src="http://a.dryicons.com/images/icon_sets/polygon_icons/png/256x256/map_pin.png"> @yield('title')</a>
    </div>

    <div class="collapse navbar-collapse" id="menu">
        <ul class="nav navbar-nav navbar-right">
            <li class="nav-item active">
                <a href="/home">Home <span class="sr-only">(current)</span></a>
            </li> 
            <li class="nav-item active">
                <a href="/cargar/documentos">Carga Documentos</a>
            </li>
            <li class="nav-item active">
                <a href="/exportar/vehiculos/documentos">Exportar Vehiculos</a>
            </li>            
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->nombre }}</a>
                <ul class="dropdown-menu">
                    <li><a href="javascript:void(0)">Perfil</a></li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            Salir
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
@endif
