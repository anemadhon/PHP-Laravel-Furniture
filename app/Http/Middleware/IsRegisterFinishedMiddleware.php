<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsRegisterFinishedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (
            is_null(auth()->user()->address_one) && 
            is_null(auth()->user()->phone_number) &&
            !auth()->user()->is_admin
            )
        {
            return redirect()->route('register-step-two.create');
        }

        return $next($request);
    }
}
