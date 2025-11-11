<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && (bool) auth()->user()->is_admin) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Acceso denegado. No tienes permisos de administrador.');
    }
}