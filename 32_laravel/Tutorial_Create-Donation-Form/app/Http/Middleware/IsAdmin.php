<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * Redirects non-admin users to the home page with an error message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->is_admin) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Unauthorized.'], 403);
            }

            return redirect('/')->with('error', 'You do not have admin access.');
        }

        return $next($request);
    }
}
