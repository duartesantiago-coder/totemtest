@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Noticias</h1>
        @if(auth()->check() && auth()->user()->is_admin)
            <a href="{{ route('noticias.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nueva Noticia
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($noticias->isEmpty())
        <div class="alert alert-info">No hay noticias publicadas.</div>
    @else
        <div class="row g-4">
            @foreach($noticias as $noticia)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card card-modern h-100 shadow-sm" style="border-radius:10px; overflow:hidden;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $noticia->titulo }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($noticia->contenido, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted">
                                    {{ $noticia->created_at->format('d/m/Y H:i') }}
                                </small>
                                <small class="text-muted">Por: {{ $noticia->autor?->name ?? 'Anónimo' }}</small>
                            </div>

                            @if(auth()->check() && auth()->user()->is_admin && auth()->user()->id === $noticia->autor_id)
                                <div class="mt-3 d-flex gap-2">
                                    <a href="{{ route('noticias.edit', $noticia) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('noticias.destroy', $noticia) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Paginación --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $noticias->links() }}
        </div>
    @endif
</div>
@endsection