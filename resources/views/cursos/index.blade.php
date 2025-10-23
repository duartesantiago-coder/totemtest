@extends('layouts.app')

@section('content')
estoy en el index de cursos
<table class="table table-bordered">
    <thead>
        <tr>
            
            <th>Año</th>
            <th>División</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cursos as $curso)
            <tr>
                
                <td>{{ $curso->anio }}</td>
                <td>{{ $curso->division }}</td>
            </tr>
        @endforeach
    </tbody>
</table>


   
@endsection
