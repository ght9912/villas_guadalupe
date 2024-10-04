<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.min.css" />
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.min.js"></script>
    <script src=" https://cdn.jsdelivr.net/npm/jszip@3.10.1/dist/jszip.min.js "></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/dataTables.buttons.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.1/css/buttons.dataTables.min.css" />
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.html5.min.js"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://unpkg.com/currency.js@~2.0.0/dist/currency.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/draggable/1.0.0-beta.12/draggable.bundle.legacy.js"></script>

    <!--<script src="{{ asset('js\selectsearch.js') }}" defer></script>-->
    <!-- Styles -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js" integrity="sha512-CQBWl4fJHWbryGE+Pc7UAxWMUMNMWzWxF4SQo9CgkJIN1kx6djDQZjh3Y8SZ1d+6I+1zze6Z7kHXO7q3UyZAWw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <style>
        .nav-link{
            color: white !important
        }
        .nav-link:hover{
            color: rgb(255, 234, 0) !important
        }
    </style>
</head>
<body>
    <div class="container-fluid" id="app">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <img src="{{asset('img/logo.png')}}" alt="" class="d-none d-md-block" style="
                    margin-left: auto;
                    margin-right: auto;
                    width: 90%;
                    margin-bottom: 10px;">
                    <span class="d-block d-md-none">VG</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu2">
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu3">


                        <li class="nav-item">
                            <a href="/" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                            </a>
                        </li>
                        {{-- <li>
                            <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span> </a>
                            <ul class="collapse nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                                <li class="w-100">
                                    <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 1 </a>
                                </li>
                                <li>
                                    <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 2 </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Orders</span></a>
                        </li>
                        <li>
                            <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                                <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">Bootstrap</span></a>
                            <ul class="collapse nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                                <li class="w-100">
                                    <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 1</a>
                                </li>
                                <li>
                                    <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 2</a>
                                </li>
                            </ul>
                        </li> --}}
                        @if(auth()->user()->isClient)

                        @endif
                        @if(auth()->user()->isSeller || auth()->user()->isAdmin)
                        <li>
                            <a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-buildings"></i> <span class="ms-1 d-none d-sm-inline">Proyectos</span> </a>
                                <ul class="collapse nav flex-column ms-1" id="submenu3" data-bs-parent="#menu2">
                                <li class="w-100">
                                    <a href="{{route('proyectos.index')}}" class="nav-link px-0"><span class="d-block d-sm-none">Ver</span> <span class="d-none d-sm-block">Ver Proyectos</span> </a>
                                </li>
                                <li>
                                    <a href="{{route('etapas.index')}}" class="nav-link px-0">Zonas</a>
                                </li>
                                <li>
                                    <a href="{{route('lotes.index')}}" class="nav-link px-0">Lotes</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#submenu4" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi bi-file-richtext"></i> <span class="ms-1 d-none d-sm-inline">Página de Ventas</span> </a>
                                <ul class="collapse nav flex-column ms-1" id="submenu4" data-bs-parent="#menu2">
                                <li class="w-100">
                                    <a href="{{route('caracteristicas.index')}}" class="nav-link px-0"><span class="d-block d-sm-none"></span> <span class="d-none d-sm-block">Características de la empresa</span> </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{route('vendedores.index')}}" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-person-workspace"></i> <span class="ms-1 d-none d-sm-inline">Vendedores</span> </a>
                        </li>

                        <li>
                            <a href="#submenu5" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-person-plus-fill"></i> <span class="ms-1 d-none d-sm-inline">CRM</span>
                            </a>
                            <ul class="collapse nav flex-column ms-1" id="submenu5" data-bs-parent="#menu">
                                <li>
                                    <a href="{{route('analiticas.index')}}" class="nav-link px-0">
                                        <i class="fs-6 bi-graph-up-arrow"></i><span class="ms-1 d-none d-sm-inline">Analítica</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('embudos.index')}}" class="nav-link px-0">
                                        <i class="fs-6 bi-funnel-fill"></i><span class="ms-1 d-none d-sm-inline">Embudos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('procesoVenta.index')}}" class="nav-link px-0">
                                        <i class="fs-6 bi-building-gear"></i><span class="ms-1 d-none d-sm-inline">Proceso de venta</span>
                                    </a>
                                </li>

                                <li class="nav-item dropdown">
                                    <a href="#" class="nav-link px-0 dropdown-toggle" id="dropdownEmbudos" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fs-6 bi-card-checklist"></i><span class="ms-1 d-none d-sm-inline">Paneles</span>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownEmbudos">
                                        @foreach($embudosAll as $embudo)
                                            <li>
                                                <a href="{{ route('panel.index', $embudo->id) }}" class="dropdown-item">
                                                    {{ $embudo->nombre }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>

                                <li>
                                    <a href="{{route('calendarioTareas.index')}}" class="nav-link px-0">
                                        <i class="fs-5 bi-calendar2-week"></i><span class="ms-1 d-none d-sm-inline">Calendarios/Tareas</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{route('clientes.index')}}" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Clientes</span> </a>
                        </li>
                        <li>
                            <a href="{{route('contratos.index')}}" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi bi-file-earmark-spreadsheet"></i> <span class="ms-1 d-none d-sm-inline">Vender Terreno / Contratos</span> </a>
                        </li>
                        <li>
                            <a href="{{route('pagos.index')}}" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi bi-cash-coin"></i> <span class="ms-1 d-none d-sm-inline">Pagos</span> </a>
                        </li>
                        <li>
                            <a href="{{route('ofertas.index')}}" class="nav-link px-0 align-middle">
                                <i class=" fs-4 bi bi-collection"></i> <span class="ms-1 d-none d-sm-inline">Ofertas</span> </a>
                        </li>
                        @endif

                    </ul>
                    <hr>
                    <div class="dropdown pb-4">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            {{-- <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30" class="rounded-circle"> --}}
                            <span class="d-none d-sm-inline mx-1">  {{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                            {{-- <li><a class="dropdown-item" href="#">New project...</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Profile</a></li> --}}
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                         </form>
                         </a>
                        </ul>

                    </div>
                </div>
            </div>
            <div class="col py-3">
                <main class="py-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
    {{-- <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Inicia sesión ') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registrarse') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>



    </div> --}}


</body>
</html>

@yield('scripts')
