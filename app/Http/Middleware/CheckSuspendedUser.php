<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSuspendedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (!$request->isMethod('get')) {
            return $next($request); // Skip middleware for non-GET methods
        }

        // Check if the user is authenticated and suspended
        if (Auth::check() && Auth::user()->suspension?->isSuspended) {
            return redirect()->route('suspended');
        }


        return $next($request);
    }
}
