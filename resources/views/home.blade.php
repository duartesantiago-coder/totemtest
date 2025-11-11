@extends('layouts.app')

@section('content')
<div class="container py-5">
    {{-- Encabezado elegante --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h3 mb-1">Gestión de Horarios</h1>
            <p class="text-muted mb-0">Consulta y administra los horarios por curso y por día.</p>

            {{-- Carrusel de noticias (debajo del encabezado) --}}
            @if(isset($noticias) && $noticias->isNotEmpty())
                <div id="noticiasCarousel" class="carousel slide mt-3" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($noticias as $idx => $n)
                            <div class="carousel-item {{ $idx === 0 ? 'active' : '' }}" style="min-height:150px;">
                                <div class="d-flex gap-3 align-items-center h-100">
                                    @if($n->imagen)
                                        <img src="{{ asset('storage/' . $n->imagen) }}" class="d-none d-md-block" style="width:160px; height:120px; object-fit:cover; border-radius:6px; flex-shrink:0;" alt="{{ $n->titulo }}">
                                    @endif
                                    <div style="flex:1; min-width:0;">
                                        <a href="{{ route('noticias.show', $n) }}" class="fw-semibold d-block">{{ Str::limit($n->titulo, 80) }}</a>
                                        <div class="small text-muted">{{ $n->created_at->format('d/m/Y H:i') }}</div>
                                        <div class="small text-truncate" style="max-width:600px;">{{ Str::limit($n->contenido, 160) }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#noticiasCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#noticiasCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Siguiente</span>
                    </button>
                </div>
            @endif
        </div>

        <div class="mt-3 mt-md-0 d-flex gap-2 align-items-center">
            {{-- Acceso rápido a días --}}
            <div class="btn-group btn-group-sm" role="group" aria-label="Días">
                @foreach ([1=>'Lun',2=>'Mar',3=>'Mié',4=>'Jue',5=>'Vie'] as $num => $abbr)
                    <a href="{{ url("/horarios/dia/$num") }}" class="btn btn-outline-primary">{{ $abbr }}</a>
                @endforeach
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success small">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger small">{{ session('error') }}</div>
    @endif

    {{-- Layout principal: izquierda cursos, derecha filtros/ayuda --}}
    <div class="row g-4">
        <div class="col-12 col-lg-9">
            <div class="card card-modern p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h5 mb-0">Cursos</h2>
                    <small class="text-muted">Ordenados por año y división</small>
                </div>

                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-3">
                    @php $cursosAll = \App\Models\Curso::orderBy('anio')->orderBy('division')->get(); @endphp
                    @foreach($cursosAll as $curso)
                        @php
                            $turno = $curso->turno ?? (in_array($curso->division, ['C','D']) ? 'tarde' : 'mañana');
                        @endphp
                        <div class="col">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="card-body p-2 d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <div class="fw-semibold">{{ $curso->anio }}° {{ $curso->division }}</div>
                                            <small class="text-muted">{{ ucfirst($turno) }}</small>
                                        </div>
                                        <span class="badge bg-light text-dark small" style="box-shadow:0 2px 6px rgba(2,6,23,0.06)">
                                            {{ $curso->id }}
                                        </span>
                                    </div>

                                    <div class="mt-auto d-grid gap-2">
                                        <a href="{{ url("/cursos/{$curso->id}/horarios") }}" class="btn btn-sm btn-primary">
                                            Ver horarios
                                        </a>

                                        {{-- Mostrar botón de cambiar turno SOLO a admins --}}
                                        @if(auth()->check() && auth()->user()->is_admin)
                                            <form action="{{ route('cursos.toggleTurno', $curso) }}" method="POST" class="m-0">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                    Cambiar turno
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if($cursosAll->isEmpty())
                        <div class="col-12">
                            <div class="text-muted small">No hay cursos cargados.</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Panel derecho: explicación, leyenda y acciones --}}
        <div class="col-12 col-lg-3">
            <div class="card card-modern p-3 mb-3">
                <h3 class="h6 mb-2">Acerca del modo</h3>
                <p class="small text-muted mb-0">Cambia el turno de un curso desde su tarjeta para que cambie en la vista de horarios.</p>
            </div>

            <div class="card card-modern p-3">
                <h3 class="h6 mb-2">Horarios, tablas principales</h3>
                <div class="d-flex flex-column gap-2">
                    <a href="{{ url('/horarios/dia/1') }}" class="btn btn-sm btn-outline-info text-start">Ver Lunes</a>
                    <a href="{{ url('/horarios/dia/2') }}" class="btn btn-sm btn-outline-info text-start">Ver Martes</a>
                    <a href="{{ url('/horarios/dia/3') }}" class="btn btn-sm btn-outline-info text-start">Ver Miércoles</a>
                    <a href="{{ url('/horarios/dia/4') }}" class="btn btn-sm btn-outline-info text-start">Ver Jueves</a>
                    <a href="{{ url('/horarios/dia/5') }}" class="btn btn-sm btn-outline-info text-start">Ver Viernes</a>
                </div>
            </div>

            @if(auth()->check() && auth()->user()->is_admin)
                <div class="card card-modern p-3 mt-3">
                    <h3 class="h6 mb-2">Administración</h3>
                    <div class="d-grid gap-2">
                        <a href="{{ route('horarios.edit', isset($cursosAll[0]) ? $cursosAll[0] : 1) }}" class="btn btn-sm btn-warning w-100">Editar horarios</a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary w-100">Gestionar usuarios</a>
                    </div>
                </div>
            @endif

            {{-- Últimas noticias --}}
            <div class="card card-modern p-3 mt-3">
                <h3 class="h6 mb-2">Últimas Noticias</h3>
                @php $noticias = \App\Models\Noticia::where('publicada', true)->orderBy('created_at', 'desc')->limit(3)->get(); @endphp
                @if($noticias->isEmpty())
                    <p class="small text-muted">No hay noticias.</p>
                @else
                    <div class="d-flex flex-column gap-2">
                        @foreach($noticias as $noticia)
                            <div style="padding:.5rem; border-left:3px solid #0ea5e9; background:rgba(14,165,233,0.05); border-radius:4px;">
                                <small class="fw-semibold">{{ Str::limit($noticia->titulo, 50) }}</small>
                                <div class="text-muted" style="font-size:.75rem;">{{ $noticia->created_at->format('d/m H:i') }}</div>
                            </div>
                        @endforeach
                        <a href="{{ route('noticias.index') }}" class="btn btn-sm btn-outline-info mt-2">Ver todas</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Pequeños ajustes estéticos específicos para home */
    .card-modern { border-radius:10px; background: rgba(255,255,255,0.92); }
    .card-modern .card-body { padding: .75rem; }
    .badge { font-weight: 600; }
    a.btn { white-space: nowrap; }
</style>
@endpush
