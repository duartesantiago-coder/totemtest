@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Editar Horarios - {{ $curso->anio }}° {{ $curso->division }}</h3>

    <form action="{{ route('horarios.update', $curso) }}" method="POST">
        @csrf
        @method('PUT')

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

                        @for($d=1; $d<=5; $d++)
                            <td>
                                @if(isset($grid[$modulo->id][$d]))
                                    @php $h = $grid[$modulo->id][$d]; @endphp
                                    <select name="aula[{{ $h->id }}]" class="form-control">
                                        @foreach($aulas as $aula)
                                            <option value="{{ $aula->id }}" {{ $aula->id == $h->aula_id ? 'selected' : '' }}>
                                                {{ $aula->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    {{-- Si no existe la fila de horario para este módulo y día, podés mostrar un select vacío o crear el horario --}}
                                    —
                                @endif
                            </td>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('horarios.index', $curso) }}" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
</div>
@endsection
