<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$role)
    {
        if(!Auth::user()->is($role) && !Auth::user()->is('Administrator')  && !Auth::user()->is('SubAdmin')) {
          return redirect()->route('home.401');
        }
        return $next($request);
    }
}
