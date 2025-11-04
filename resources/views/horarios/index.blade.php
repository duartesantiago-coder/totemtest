@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Horarios - {{ $curso->anio }}° {{ $curso->division }}</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Módulo</th>
                <th>Lunes</th>
                <th>Martes</th>
                <th>Miércoles</th>
                <th>Jueves</th>
                <th>Viernes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($modulos as $modulo)
                <tr>
                    <td>{{ $modulo->hora_inicio }} - {{ $modulo->hora_fin }}</td>

                    @for($d = 1; $d <= 5; $d++)
                        <td>
                            @if(isset($grid[$modulo->id][$d]))
                                {{ $grid[$modulo->id][$d]->aula->nombre ?? '—' }}
                            @else
                                —
                            @endif
                        </td>
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('horarios.edit', $curso) }}" class="btn btn-primary">Editar</a>
</div>
@endsection
