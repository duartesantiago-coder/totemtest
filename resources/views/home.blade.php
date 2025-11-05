@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    {{-- Banner principal --}}
    <div class="p-5 mb-5 bg-primary text-white rounded shadow">
        <h1 class="fw-bold">Gestión de Horarios</h1>
        <p class="lead">Selecciona un curso o consulta los horarios por día</p>
    </div>

    {{-- Sección de cursos --}}
    <h3 class="mb-3">Cursos</h3>
    <div class="row g-2 justify-content-center mb-5">
        @for ($anio = 1; $anio <= 5; $anio++)
            @foreach (['A', 'B', 'C', 'D'] as $division)
                @php
                    $cursoId = ($anio - 1) * 4 + array_search($division, ['A', 'B', 'C', 'D']) + 1;
                @endphp
                <div class="col-6 col-md-2">
                    <a href="{{ url("/cursos/$cursoId/horarios") }}" class="btn btn-outline-primary w-100">
                        {{ $anio }}° {{ $division }}
                    </a>
                </div>
            @endforeach
        @endfor
    </div>

    {{-- Sección de días --}}
    <h3 class="mb-3">Horarios por Día</h3>
    <div class="row g-2 justify-content-center">
        @foreach ([1=>'Lunes',2=>'Martes',3=>'Miércoles',4=>'Jueves',5=>'Viernes'] as $num => $nombre)
            <div class="col-6 col-md-2">
                <a href="{{ url("/horarios/dia/$num") }}" class="btn btn-outline-success w-100">
                    {{ $nombre }}
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
