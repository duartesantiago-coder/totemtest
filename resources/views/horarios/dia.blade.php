@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Horarios del día {{ ["Lunes","Martes","Miércoles","Jueves","Viernes"][$dia-1] }}</h2>

    <table class="table table-bordered text-center align-middle">
        <thead class="table-dark">
            <tr>
                <th>Curso</th>
                @foreach($modulos as $modulo)
                    <th>
                        {{ $modulo->nombre }}<br>
                        <small>{{ $modulo->hora_inicio }} - {{ $modulo->hora_fin }}</small>
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($cursosVisibles as $curso)
                <tr>
                    <th>{{ $curso->anio }}° {{ $curso->division }}</th>
                    @foreach($modulos as $modulo)
                        @php
                            // Acceso seguro al grid para evitar claves no definidas
                            $aula = $grid[$curso->id][$modulo->id] ?? 'Vacío';
                            $clase = $aula === 'Vacío' ? 'bg-light text-muted' : 'text-white';
                        @endphp
                        <td class="{{ $clase }}" style="background-color: {{ $aula !== 'Vacío' ? '#' . substr(md5($aula), 0, 6) : '' }}">
                            {{ $aula }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
