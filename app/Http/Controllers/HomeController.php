<?php

namespace App\Http\Controllers;
use App\Models\Curso;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    public function index() {
        $cursos = Curso::orderBy('anio')->orderBy('division')->get();
        $noticias = \App\Models\Noticia::where('publicada', true)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        return view('home', compact('cursos','noticias'));
    }
}
