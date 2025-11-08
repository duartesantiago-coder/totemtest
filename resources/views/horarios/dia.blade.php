@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Horarios del día {{ $nombreDia }}</h2>
        
        {{-- Botones para cambiar turno --}}
        <div class="btn-group">
            <a href="{{ route('horarios.mostrarPorDia', ['dia' => $dia, 'turno' => 'mañana']) }}" 
               class="btn btn-outline-primary {{ $turno == 'mañana' ? 'active' : '' }}">
                Turno Mañana
            </a>
            <a href="{{ route('horarios.mostrarPorDia', ['dia' => $dia, 'turno' => 'tarde']) }}" 
               class="btn btn-outline-primary {{ $turno == 'tarde' ? 'active' : '' }}">
                Turno Tarde
            </a>
        </div>
    </div>

    @if($cursos->isEmpty())
        <div class="alert alert-info">No hay cursos para el turno {{ $turno }}</div>
    @else
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Curso</th>
                    @foreach($modulos as $modulo)
                        <th>
                            {{ $modulo->hora_inicio }} - {{ $modulo->hora_final }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($cursos as $curso)
                    <tr>
                        <th>{{ $curso->anio }}° {{ $curso->division }}</th>
                        @foreach($modulos as $modulo)
                            <td>{{ $grid[$curso->id][$modulo->id] ?? '—' }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
