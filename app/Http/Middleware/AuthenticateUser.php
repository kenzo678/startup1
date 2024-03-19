<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthenticateUser
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect('/home'); // Redirect to the login page if user is not authenticated
        }

        return $next($request);
    }
}
