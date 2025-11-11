@extends('layouts.app')

@section('content')
<div class="container py-5">
    {{-- Encabezado elegante --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h3 mb-1">Gestión de Horarios</h1>
            <p class="text-muted mb-0">Consulta y administra los horarios por curso y por día.</p>
        </div>

        <div class="mt-3 mt-md-0 d-flex gap-2 align-items-center">
            {{-- Estado del modo traspao (form POST, recarga) --}}
            <form action="{{ route('modo.toggle') }}" method="POST">
                @csrf
                <button type="submit"
                        class="btn btn-sm {{ session('modo_traspao') ? 'btn-warning' : 'btn-outline-secondary' }}">
                    {{ session('modo_traspao') ? 'Modo traspao: ON' : 'Modo traspao: OFF' }}
                </button>
            </form>

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
                <p class="small text-muted mb-0">Activa "Modo traspao" para cambiar el turno de un curso desde su tarjeta. Sin el modo activado, los botones navegan a la vista de horarios.</p>
            </div>

            <div class="card card-modern p-3">
                <h3 class="h6 mb-2">Atajos</h3>
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
                    <a href="{{ route('horarios.edit', isset($cursosAll[0]) ? $cursosAll[0] : 1) }}" class="btn btn-sm btn-warning w-100">Editar horarios</a>
                </div>
            @endif
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
