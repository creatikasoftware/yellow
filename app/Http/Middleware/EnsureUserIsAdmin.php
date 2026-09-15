<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Restrict access to authenticated users flagged as admin.
     *
     * Pairs with the 'auth' middleware (which handles "not logged in").
     * This handles "logged in but not authorized" by aborting with 403.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isAdmin()) {
            abort(403, 'You are not authorized to access the admin panel.');
        }

        return $next($request);
    }
}
