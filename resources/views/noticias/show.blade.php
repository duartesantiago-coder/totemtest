@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="card mb-4">
                @if($noticia->imagen)
                    <img src="{{ asset('storage/' . $noticia->imagen) }}" class="card-img-top" alt="{{ $noticia->titulo }}">
                @endif
                <div class="card-body">
                    <h1 class="h4">{{ $noticia->titulo }}</h1>
                    <div class="mb-3 text-muted small">
                        {{ $noticia->created_at->format('d/m/Y H:i') }} • Por: {{ $noticia->autor?->name ?? 'Anónimo' }}
                    </div>

                    <div class="mb-4">
                        {!! nl2br(e($noticia->contenido)) !!}
                    </div>

                    <a href="{{ route('noticias.index') }}" class="btn btn-secondary">Volver a noticias</a>

                    @if(auth()->check() && (auth()->user()->is_admin || auth()->id() === $noticia->autor_id))
                        <a href="{{ route('noticias.edit', $noticia) }}" class="btn btn-sm btn-warning ms-2">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('noticias.destroy', $noticia) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar esta noticia?');">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger ms-2">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
