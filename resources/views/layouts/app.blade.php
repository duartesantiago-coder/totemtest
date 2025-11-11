<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

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
    </style>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <div id="app" class="app-shell">
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

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
