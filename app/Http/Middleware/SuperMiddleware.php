<?php

namespace App\Http\Middleware;

use Closure;

class SuperMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard=null)
    {
        if ($request->user() && $request->user()->permission != config('constants.SUPER-ADMIN')) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
