<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>M.I.G.A</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    {{-- Tipografía y estilos globales mejorados --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root{
            --accent-1: #0ea5e9;
            --accent-2: #34d399;
            --bg-soft: #f6fbff;
            --card-bg: rgba(255,255,255,0.85);
            --muted: #6b7280;
            --glass: rgba(255,255,255,0.6);
            --table-border: #e6f0fb;
        }

        html,body{
            font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            background: linear-gradient(180deg,#f8fbff 0%, #eef9f7 100%);
            color: #0f172a;
        }

        .app-shell{
            min-height:100vh;
            padding: 1.25rem;
        }

        .page-header{
            background: linear-gradient(135deg, rgba(14,165,233,0.95) 0%, rgba(52,211,153,0.95) 100%);
            color: #fff;
            padding: 1.25rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(2,6,23,0.08);
        }

        .card-modern{
            background: var(--card-bg);
            border: 0;
            border-radius: 10px;
            box-shadow: 0 6px 18px rgba(15,23,42,0.06);
            overflow: hidden;
        }

        table.table-modern{
            width:100%;
            border-collapse: separate;
            border-spacing: 0;
            table-layout: fixed;
        }
        table.table-modern thead th{
            background: linear-gradient(90deg, rgba(30,136,229,0.95), rgba(100,181,246,0.9));
            color: #fff;
            border: none;
            padding: .9rem .6rem;
            font-weight:600;
            text-align:center;
        }
        table.table-modern tbody td, table.table-modern tbody th{
            border-bottom: 1px solid var(--table-border);
            padding: .7rem .6rem;
            vertical-align: middle;
        }

        .aula-badge{
            display:inline-block;
            padding:.35rem .6rem;
            border-radius: 999px;
            font-size:.85rem;
            font-weight:600;
            box-shadow: 0 2px 8px rgba(2,6,23,0.08);
        }

        .legend{
            display:flex;
            gap:.5rem;
            flex-wrap:wrap;
        }
        .legend-item{
            display:flex;
            align-items:center;
            gap:.5rem;
            padding:.2rem .5rem;
            background: rgba(255,255,255,0.6);
            border-radius:999px;
            font-size:.85rem;
            color:var(--muted);
            box-shadow: 0 2px 8px rgba(2,6,23,0.04);
        }
        .legend-swatch{ width:18px; height:18px; border-radius:6px; box-shadow: inset 0 -1px 0 rgba(0,0,0,0.08); }

        /* responsive */
        @media (max-width: 900px){
            .page-header { padding: 1rem; font-size:.95rem; }
            table.table-modern thead th { font-size:.78rem; padding:.6rem .4rem; }
            table.table-modern tbody td { font-size:.82rem; padding:.5rem .4rem; }
        }

    /* Helpers for schedules table */
    .table-wrap{ position:relative; }
    .table-scroll{ overflow:auto; scroll-behavior:smooth; -webkit-overflow-scrolling:touch; }
    /* when we need the table to fit without scrolling, add .no-scroll to .table-scroll */
    .table-scroll.no-scroll{ overflow:visible; }
    /* default table layout: full width */
    table.table-modern{ width:100%; table-layout: fixed; }
    table.table-modern th, table.table-modern td{ padding:.45rem .45rem; font-size:.9rem; white-space:nowrap; text-overflow:ellipsis; overflow:hidden; }
    table.table-modern th{ min-width:90px; }

    /* compact mode: rotate headers and shrink padding/font to force fit */
    table.table-modern.table-compact{ table-layout: fixed; width:100%; }
    table.table-modern.table-compact th{ writing-mode: vertical-rl; transform: rotate(180deg); padding:.25rem .2rem; min-width:34px; font-size:.72rem; text-align:center; }
    table.table-modern.table-compact td{ padding:.22rem .25rem; font-size:.78rem; white-space:normal; }
    /* hide scroll buttons when using no-scroll */
    .table-wrap .table-scroll.no-scroll ~ .scroll-btn{ display:none; }

        .scroll-btn{ position:absolute; top:8px; width:36px; height:36px; border-radius:8px; background:rgba(255,255,255,0.95); box-shadow:0 6px 18px rgba(2,6,23,0.08); display:flex; align-items:center; justify-content:center; cursor:pointer; z-index:30; border:0; }
        .scroll-btn svg{ width:18px; height:18px; }
        .scroll-btn.left{ left:6px; }
        .scroll-btn.right{ right:6px; }
    </style>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <div id="app" class="app-shell">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}" style="font-weight:700; font-size:1.45rem; letter-spacing:1px;">
                    <span style="display:inline-block; background:linear-gradient(135deg,#0ea5e9,#34d399); border-radius:8px; padding:2px 10px 2px 8px; margin-right:6px;">
                        <svg width="28" height="28" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;">
                            <circle cx="16" cy="16" r="16" fill="#0ea5e9"/>
                            <path d="M8 20L16 8L24 20H8Z" fill="#fff"/>
                        </svg>
                    </span>
                    <span style="font-family:'Inter',Nunito,sans-serif; color:#0ea5e9; text-shadow:0 2px 8px #e0f2fe;">M.I.G.A</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            @php $noticiasCount = \App\Models\Noticia::where('publicada',1)->count(); @endphp
                            <a class="nav-link fw-semibold {{ request()->routeIs('noticias.*') ? 'active' : '' }}" href="{{ route('noticias.index') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-newspaper me-1 mb-1" viewBox="0 0 16 16">
                                  <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H2z"/>
                                  <path d="M2 6h12v1H2V6zm0 2h12v1H2V8zm0 2h8v1H2v-1z"/>
                                </svg>
                                Noticias
                                @if($noticiasCount > 0)
                                    <span class="badge bg-danger ms-2">{{ $noticiasCount }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    {{-- Logout como formulario para que funcione incluso si JS está deshabilitado --}}
                                    <form action="{{ route('logout') }}" method="POST" style="display:flex; justify-content:center; width:100%;">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-center" style="background:none; border:0; padding:0.5rem 1rem; margin:0; width:100%; display:block;">
                                            {{ __('Logout') }}
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

            {{-- Bootstrap JS bundle (required for modals/carousel/tooltips) --}}
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="" crossorigin="anonymous"></script>

            <script>
                // Simple dropdown toggle para el navbar
                document.addEventListener('DOMContentLoaded', function() {
                    var dropdownToggle = document.getElementById('navbarDropdown');
                    if (dropdownToggle) {
                        dropdownToggle.addEventListener('click', function(e) {
                            e.preventDefault();
                            var menu = this.nextElementSibling;
                            if (menu) {
                                menu.classList.toggle('show');
                                this.setAttribute('aria-expanded', menu.classList.contains('show'));
                            }
                        });
                        
                        // Cerrar dropdown al hacer click fuera
                        document.addEventListener('click', function(e) {
                            if (!e.target.closest('.dropdown')) {
                                document.querySelectorAll('.dropdown-menu.show').forEach(function(m) {
                                    m.classList.remove('show');
                                });
                            }
                        });
                    }
                });
            </script>

            @stack('scripts')
</body>
</html>
