<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckEditorOrAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (! $user) {
            abort(403);
        }

        if ($user->is_admin || $user->isEditor()) {
            return $next($request);
        }

        abort(403);
    }
}
