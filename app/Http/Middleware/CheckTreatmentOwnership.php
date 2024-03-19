<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTreatmentOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //return $next($request);
        $treatment = Treatment::findOrFail($request->route()->parameter('treatment'));

        if (auth()->check() && $treatment && auth()->user()->id == $treatment->pet->user_id) {
            return $next($request);
        }

        return redirect('/');

    }
}
