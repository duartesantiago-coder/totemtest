@extends('layouts.app')

@section('content')
estoy en el index de horarios
<table class="table table-bordered">
    <thead>
        <tr>
            
            <th>Aula</th>
            <th>Modulo</th>
            <th>Curso</th>
            <th>Día</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($horarios as $horario)
            <tr>
                
                <td>{{ $horario->aula_id }}</td>
                <td>{{ $horario->modulo_id }}</td>
                <td>{{ $horario->curso_id }}</td>
                <td>{{ $horario->dia }}</td>
                
            </tr>
        @endforeach
    </tbody>
</table>


   
@endsection
