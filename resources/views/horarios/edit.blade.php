@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Editar Horarios - {{ $curso->anio }}° {{ $curso->division }}</h3>

    <form action="{{ route('horarios.update', $curso) }}" method="POST">
        @csrf

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead class="table-dark">
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
                                <td class="fw-bold">
                                    {{ $modulo->hora_inicio }} - {{ $modulo->hora_final }}
                                </td>
                                @for($dia = 1; $dia <= 5; $dia++)
                                    @php
                                        $horario = $grid[$modulo->id][$dia] ?? null;
                                    @endphp
                                    <td>
                                        <select name="aula[{{ $horario->id ?? 0 }}]" class="form-select form-select-sm">
                                            <option value="">-- Seleccionar aula --</option>
                                            @foreach($aulas as $aula)
                                                <option value="{{ $aula->id }}" 
                                                    {{ ($horario && $horario->aula_id == $aula->id) ? 'selected' : '' }}>
                                                    {{ $aula->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('horarios.index', $curso) }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </form>
</div>
@endsection
