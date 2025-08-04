<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ChatifyAuthenticate
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('admin')->check()) {
            Auth::shouldUse('admin');
        } elseif (Auth::guard('web')->check()) {
            Auth::shouldUse('web');
        }

        return $next($request);
    }
}
