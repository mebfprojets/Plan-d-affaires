<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if ($request->expectsJson()) {
            return null;
        }

        // Vérifie le chemin ou le guard pour rediriger vers la bonne route
        if ($request->is('admin/*')) {
            return route('admin.login');
        }

        return route('login');
    }
}
