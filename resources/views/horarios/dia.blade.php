@extends('layouts.app')

@section('content')
<div class="container mt-4">
    {{-- Header con gradiente --}}
    <div class="p-4 mb-4 rounded-3 shadow-sm" style="background: linear-gradient(135deg, #0099f7 0%, #00ff95 100%);">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-white mb-0" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.2);">
                <i class="fas fa-calendar-day me-2"></i>
                Horarios del día {{ $nombreDia }}
            </h2>
            
            {{-- Botones para cambiar turno con diseño mejorado --}}
            <div class="btn-group shadow">
                <a href="{{ route('horarios.mostrarPorDia', ['dia' => $dia, 'turno' => 'mañana']) }}" 
                   class="btn {{ $turno == 'mañana' ? 'btn-warning' : 'btn-light' }} px-4">
                    <i class="fas fa-sun me-2"></i>
                    Turno Mañana
                </a>
                <a href="{{ route('horarios.mostrarPorDia', ['dia' => $dia, 'turno' => 'tarde']) }}" 
                   class="btn {{ $turno == 'tarde' ? 'btn-info' : 'btn-light' }} px-4">
                    <i class="fas fa-moon me-2"></i>
                    Turno Tarde
                </a>
            </div>
        </div>
    </div>

    @if($cursos->isEmpty())
        <div class="alert alert-info shadow-sm border-0" style="background: linear-gradient(135deg, #e0f7fa 0%, #b2ebf2 100%);">
            <i class="fas fa-info-circle me-2"></i>
            No hay cursos para el turno {{ $turno }}
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover table-bordered mb-0">
                    <thead>
                        <tr class="text-white" style="background: linear-gradient(135deg, #1e88e5 0%, #64b5f6 100%);">
                            <th class="py-3">Curso</th>
                            @foreach($modulos as $modulo)
                                <th class="py-3 text-center">
                                    <div class="fw-bold">{{ $modulo->hora_inicio }} - {{ $modulo->hora_final }}</div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cursos as $curso)
                            @php
                                // Verificar si el curso tiene al menos una celda con valor
                                $tieneDatos = false;
                                foreach ($modulos as $modulo) {
                                    $valor = $grid[$curso->id][$modulo->id] ?? '—';
                                    if ($valor !== '—' && $valor !== 'Vacío') {
                                        $tieneDatos = true;
                                        break;
                                    }
                                }
                            @endphp

                            @if($tieneDatos)
                                <tr>
                                    <th class="bg-light text-primary">
                                        <div class="d-flex align-items-center py-2">
                                            <i class="fas fa-graduation-cap me-2"></i>
                                            {{ $curso->anio }}° {{ $curso->division }}
                                        </div>
                                    </th>
                                    @foreach($modulos as $modulo)
                                        @php
                                            $valor = $grid[$curso->id][$modulo->id] ?? '—';
                                            $esVacio = $valor === '—' || $valor === 'Vacío';
                                        @endphp
                                        <td class="text-center align-middle {{ $esVacio ? 'text-muted bg-light' : 'bg-info bg-opacity-10' }}">
                                            @if(!$esVacio)
                                                <span class="badge bg-info bg-opacity-75 px-3 py-2">
                                                    {{ $valor }}
                                                </span>
                                            @else
                                                <i class="fas fa-minus text-muted"></i>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @if(auth()->check() && auth()->user()->isAdmin())
        {{-- Mostrar botones de edición solo a admins --}}
        <div class="btn-group shadow mt-3">
            @foreach($cursos as $curso)
                <a href="{{ route('horarios.edit', $curso) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit"></i> Editar {{ $curso->anio }}° {{ $curso->division }}
                </a>
            @endforeach
        </div>
    @endif
</div>

{{-- Agregar FontAwesome si no está incluido en app.blade.php --}}
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .table th, .table td {
        border-color: #e3f2fd;
    }
    .badge {
        font-weight: normal;
    }
    .btn-group .btn {
        transition: all 0.3s ease;
    }
    .btn-group .btn:hover {
        transform: translateY(-2px);
    }
</style>
@endpush
@endsection
