<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class UserSessionMiddleware
{
    public function handle($request, Closure $next)
    {
        Config::set('session.cookie', 'user_session');

        if (!Auth::guard('web')->check()) {
            return redirect()->route('login'); // adapte si besoin
        }
        return $next($request);
    }
}
