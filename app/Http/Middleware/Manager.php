<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Manager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->role == 1) {
            return redirect()->route('admin');
            
        }

        if (Auth::user()->role == 2) {
            return $next($request);
        }

        if (Auth::user()->role == 3) {
            return redirect()->route('customer');
        }
    }
}
