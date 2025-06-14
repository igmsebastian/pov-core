<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Access\AuthorizationException;

class EnsureUserHasModuleAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $module): Response
    {
        $user = $request->user();

        if (! $user || ! $user->currentAccessToken()) {
            throw new AuthenticationException();
        }

        if ($user->tokenCan('*:*')) {
            return $next($request);
        }

        if (in_array($module, $user->configs['modules'])) {
            return $next($request);
        }

        throw new AuthorizationException();
    }
}
