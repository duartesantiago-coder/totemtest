@extends('layouts.app')

@section('content')
<div class="container">

    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="h4 mb-0">Horarios — {{ $nombreDia ?? 'Día' }}</h2>
                <small class="d-block mt-1" style="opacity:.9">Turno: <strong>{{ ucfirst($turno ?? 'mañana') }}</strong></small>
            </div>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('horarios.mostrarPorDia', ['dia'=>$dia, 'turno'=>'mañana']) }}"
                   class="btn {{ ($turno ?? 'mañana')=='mañana' ? 'btn btn-sm btn-light' : 'btn btn-sm btn-outline-light' }}">
                   Mañana
                </a>
                <a href="{{ route('horarios.mostrarPorDia', ['dia'=>$dia, 'turno'=>'tarde']) }}"
                   class="btn {{ ($turno ?? 'mañana')=='tarde' ? 'btn btn-sm btn-light' : 'btn btn-sm btn-outline-light' }}">
                   Tarde
                </a>
            </div>
        </div>
    </div>

    @php
        $aulasUnicas = [];
        foreach($grid as $cursoId => $fila){
            foreach($fila as $modId => $valor){
                if($valor && $valor !== 'Vacío' && $valor !== '—'){
                    $aulasUnicas[$valor] = $valor;
                }
            }
        }
        $colorFor = function($name){ $hex = substr(md5($name),0,6); return "#{$hex}"; };
        $contrast = function($hex){
            $hex = str_replace('#','',$hex);
            $r = hexdec(substr($hex,0,2)); $g = hexdec(substr($hex,2,2)); $b = hexdec(substr($hex,4,2));
            $lum = (0.299*$r + 0.587*$g + 0.114*$b)/255;
            return $lum > 0.6 ? '#0b1220' : '#ffffff';
        };
    @endphp

    @if(!empty($aulasUnicas))
        <div class="mb-3">
            <div class="legend">
                @foreach($aulasUnicas as $nombre)
                    @php $c = $colorFor($nombre); $txt = $contrast($c); @endphp
                    <div class="legend-item">
                        <span class="legend-swatch" style="background: {{ $c }};"></span>
                        <strong style="color:{{ $txt }}; background:{{ $c }}; padding:.15rem .5rem; border-radius:6px; font-weight:600;">{{ $nombre }}</strong>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if($cursos->isEmpty())
        <div class="alert alert-info card-modern p-3">No hay cursos para el turno seleccionado.</div>
    @else
        <div class="card-modern">
            <div class="p-3">
                <div style="overflow:auto;">
                    <table class="table-modern">
                        <thead>
                            <tr>
                                <th style="min-width:140px; text-align:left;">Curso</th>
                                @foreach($modulos as $modulo)
                                    <th style="min-width:130px;">
                                        <div style="font-weight:700;">{{ $modulo->hora_inicio }}<br><small style="opacity:.75;">{{ $modulo->hora_final }}</small></div>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cursos as $curso)
                                @php
                                    $mostrar = false;
                                    foreach($modulos as $modulo){
                                        $v = $grid[$curso->id][$modulo->id] ?? '—';
                                        if($v !== '—' && $v !== 'Vacío'){ $mostrar = true; break; }
                                    }
                                @endphp

                                @if($mostrar)
                                    <tr>
                                        <th style="background:transparent; text-align:left;">
                                            <div style="display:flex; align-items:center; gap:.6rem;">
                                                <div style="width:10px; height:28px; background: linear-gradient(180deg, rgba(14,165,233,0.9), rgba(52,211,153,0.9)); border-radius:4px;"></div>
                                                <div>
                                                    <div style="font-weight:700;">{{ $curso->anio }}° {{ $curso->division }}</div>
                                                    <small style="color:var(--muted)">{{ $curso->turno ?? (in_array($curso->division,['C','D']) ? 'tarde' : 'mañana') }}</small>
                                                </div>
                                            </div>
                                        </th>

                                        @foreach($modulos as $modulo)
                                            @php
                                                $valor = $grid[$curso->id][$modulo->id] ?? '—';
                                                $esVacio = ($valor === '—' || $valor === 'Vacío');
                                                $bg = $esVacio ? 'transparent' : $colorFor($valor);
                                                $fg = $esVacio ? 'var(--muted)' : $contrast($bg);
                                            @endphp
                                            <td style="text-align:center;">
                                                @if($esVacio)
                                                    <div style="color:var(--muted); font-size:.95rem;">—</div>
                                                @else
                                                    <div class="aula-badge" style="background: {{ $bg }}; color: {{ $fg }};">
                                                        {{ $valor }}
                                                    </div>
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
        </div>
    @endif

</div>
@endsection
