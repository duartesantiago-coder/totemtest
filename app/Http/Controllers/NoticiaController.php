<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoticiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Soporta búsqueda por título/contenido con parámetro ?q=
        $q = request()->query('q');
        $query = Noticia::where('publicada', true);
        if ($q) {
            $query->where(function($sub) use ($q) {
                $sub->where('titulo', 'like', "%{$q}%")
                    ->orWhere('contenido', 'like', "%{$q}%");
            });
        }

        $noticias = $query->orderBy('created_at', 'desc')
                          ->paginate(9)
                          ->withQueryString();

        return view('noticias.index', compact('noticias', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('noticias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'publicada' => 'boolean',
            'imagen' => 'nullable|image|max:2048'
        ]);

        $validated['autor_id'] = auth()->id();

        // Manejar upload de imagen si existe
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('noticias', 'public');
            $validated['imagen'] = $path;
        }

        Noticia::create($validated);

        return redirect()->route('noticias.index')
                       ->with('success', 'Noticia publicada correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function show(Noticia $noticia)
    {
        // Permitir ver la noticia solo si está publicada, o si el usuario es admin/autor
        if (! $noticia->publicada) {
            if (! auth()->check() || (! auth()->user()->isAdmin() && auth()->id() !== $noticia->autor_id)) {
                abort(403);
            }
        }

        return view('noticias.show', compact('noticia'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function edit(Noticia $noticia)
    {
        $this->authorize('update', $noticia);
        return view('noticias.edit', compact('noticia'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Noticia $noticia)
    {
        $this->authorize('update', $noticia);

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'publicada' => 'boolean',
            'imagen' => 'nullable|image|max:2048'
        ]);

        // Manejar reemplazo de imagen
        if ($request->hasFile('imagen')) {
            // borrar anterior si existe
            if ($noticia->imagen) {
                Storage::disk('public')->delete($noticia->imagen);
            }
            $path = $request->file('imagen')->store('noticias', 'public');
            $validated['imagen'] = $path;
        }

        $noticia->update($validated);

        return redirect()->route('noticias.index')
                       ->with('success', 'Noticia actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Noticia $noticia)
    {
        $this->authorize('delete', $noticia);
        $noticia->delete();

        return redirect()->route('noticias.index')
                       ->with('success', 'Noticia eliminada.');
    }
}
