<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Access\AuthorizationException;

class EnsureUserHasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permissions): Response
    {
        $user = $request->user();

        if (! $user || ! $user->currentAccessToken()) {
            throw new AuthenticationException();
        }

        if ($user->tokenCan('*:*')) {
            return $next($request);
        }

        $required = array_map('trim', explode(',', $permissions));

        foreach ($required as $perm) {
            if ($user->tokenCan($perm)) {
                return $next($request);
            }
        }

        throw new AuthorizationException();
    }
}
