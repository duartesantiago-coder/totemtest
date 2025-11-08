@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center">
        Horarios del día 
        @php
            $dias = [1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes'];
        @endphp
        {{ $dias[$dia] ?? 'Día desconocido' }}
    </h2>

    @if ($cursos->isEmpty())
        <div class="alert alert-info text-center">
            No hay cursos con aulas asignadas para este día.
        </div>
    @else
        @foreach ($cursos as $cursoId => $horarios)
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        {{ $horarios->first()->curso->anio }}° {{ $horarios->first()->curso->division }}
                    </h5>
                </div>
                <div class="mb-3 text-center">
                    <a href="{{ route('horarios.mostrarPorDia', ['dia' => $dia, 'turno' => 'mañana']) }}" 
                    class="btn btn-primary {{ $turno == 'mañana' ? 'active' : '' }}">
                    Turno Mañana
                    </a>
                    <a href="{{ route('horarios.mostrarPorDia', ['dia' => $dia, 'turno' => 'tarde']) }}" 
                    class="btn btn-secondary {{ $turno == 'tarde' ? 'active' : '' }}">
                    Turno Tarde
                    </a>
                </div>                
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 20%">Módulo</th>
                                <th style="width: 80%">Aula</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($horarios as $horario)
                                <tr>
                                    <td>{{ $horario->modulo->nombre ?? 'Sin módulo' }}</td>
                                    <td>
                                        {{ $horario->aula->nombre ?? 'Vacío' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
