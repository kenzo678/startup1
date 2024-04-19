<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckVetOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        $vet = $request->route()->parameter('vet');

        if (auth()->guard('veterinaria')->check() && $vet && auth()->guard('veterinaria')->user()->id == $vet->veterinaria_id) {
            return $next($request);
        }

        return redirect('/clinica'); //vet or clinica?
    }
}
