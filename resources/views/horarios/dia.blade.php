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
        // Abreviador sencillo para nombres largos de aulas
        $abbrev = function($text) {
            if(!$text) return $text;
            $map = [
                'Extranjera' => 'Ext.',
                'Extranjero' => 'Ext.',
                'Lengua' => 'Leng.',
                'Matemática' => 'Mat.',
                'Matematicas' => 'Mat.',
                'Historia' => 'Hist.',
                'Geografía' => 'Geo.',
                'Educación' => 'Ed.',
                'Física' => 'Fís.',
                'Química' => 'Quím.',
                'Biología' => 'Bio.',
                'Tecnología' => 'Tec.'
            ];
            // Reemplazos por palabra (manteniendo mayúsculas iniciales)
            $words = preg_split('/(\s+)/u', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
            foreach($words as &$w){
                $wClean = trim($w);
                if(isset($map[$wClean])){ $w = str_replace($wClean, $map[$wClean], $w); }
            }
            $short = implode('', $words);
            // Si sigue siendo muy largo, truncar y añadir punto
            if(mb_strlen($short) > 18){
                $short = mb_substr($short,0,18) . '…';
            }
            return $short;
        };
    @endphp

    @if(!empty($aulasUnicas))
        <div class="mb-3">
            <div class="legend">
                @foreach($aulasUnicas as $nombre)
                    @php $c = $colorFor($nombre); $txt = $contrast($c); @endphp
                    <div class="legend-item">
                        <span class="legend-swatch" style="background: {{ $c }};"></span>
                        <strong title="{{ $nombre }}" style="color:{{ $txt }}; background:{{ $c }}; padding:.15rem .5rem; border-radius:6px; font-weight:600;">{{ $abbrev($nombre) }}</strong>
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
                @php $compact = count($modulos) > 10; @endphp
                <div class="table-wrap">
                    <div id="horario-scroll" class="table-scroll {{ $compact ? 'no-scroll' : '' }}">
                        <table class="table-modern {{ $compact ? 'table-compact' : '' }}">
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
                                                @php
                                                    $coloresPorAnio = [
                                                        1 => '#0ea5e9', // azul
                                                        2 => '#34d399', // verde
                                                        3 => '#fbbf24', // amarillo
                                                        4 => '#818cf8', // violeta
                                                        5 => '#fb7185', // rosa
                                                    ];
                                                    $colorAnio = $coloresPorAnio[$curso->anio] ?? '#e5e7eb';
                                                @endphp
                                                <div style="width:10px; height:28px; background: {{ $colorAnio }}; border-radius:4px;"></div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="aula-badge" style="background: {{ $colorAnio }}; color: #fff; min-width:2.2em; text-align:center; font-size:1.08em;">
                                                        {{ $curso->anio }}
                                                    </span>
                                                    <div>
                                                        <div style="font-weight:700;">{{ $curso->anio }}° {{ $curso->division }}</div>
                                                        <small style="color:var(--muted)">{{ $curso->turno ?? (in_array($curso->division,['C','D']) ? 'tarde' : 'mañana') }}</small>
                                                    </div>
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
                                                        <div class="aula-badge" title="{{ $valor }}" style="background: {{ $bg }}; color: {{ $fg }};">
                                                            {{ $abbrev($valor) }}
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
        </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    function scrollHorario(px){
        var el = document.getElementById('horario-scroll');
        if(!el) return;
        el.scrollBy({ left: px, behavior: 'smooth' });
    }

    // enable horizontal scroll with mouse wheel (shift or normal)
    (function(){
        var el = document.getElementById('horario-scroll');
        if(!el) return;
        el.addEventListener('wheel', function(e){
            // if user scrolls vertically, translate to horizontal for convenience
            if(Math.abs(e.deltaY) > Math.abs(e.deltaX)){
                e.preventDefault();
                el.scrollBy({ left: e.deltaY, behavior: 'auto' });
            }
        }, { passive: false });
    })();
</script>
@endpush
