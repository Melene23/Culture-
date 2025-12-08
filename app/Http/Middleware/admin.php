<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class admin  // 'admin' avec 'a' minuscule
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        
        // Vérifier si admin (id_role = 1)
        if ($user->id_role == 1) {
            return $next($request);
        }
        
        return redirect('/')->with('error', 'Accès admin seulement');
    }
}
