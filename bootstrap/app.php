<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
// use App\Http\Middleware\ChatifyAuthenticate;
use App\Http\Middleware\Authenticate;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        // $middleware->append(ChatifyAuthenticate::class);
        // Enregistrement du middleware auth personnalisé
        $middleware->alias([
            'auth' => Authenticate::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (HttpException $e, Request $request) {
        if ($e->getStatusCode() === 419) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Session expirée. Veuillez rafraîchir.'], 419);
            }

            $route = request()->route();
            $middlewares = $route->gatherMiddleware(); // Donne tous les middleware appliqués à la route
            if (in_array('auth:admin', $middlewares)) {
                return redirect()->route('admin.login')
                                 ->with('error', 'Session expirée. Veuillez vous reconnecter.');
            }

            return redirect()->guest(route('login'))
                             ->with('error', 'Session expirée. Veuillez vous reconnecter.');
        }

        return null; // Continue vers le handler par défaut sinon
    });
    })->create();
