<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class AdminSessionMiddleware
{
    public function handle($request, Closure $next)
    {
        Config::set('session.cookie', 'admin_session');
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login'); // adapte si besoin
        }

        return $next($request);
    }
}
