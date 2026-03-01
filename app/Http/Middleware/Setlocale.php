<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class Setlocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $locale = session('locale',config('app.locale'));
        // app()->setlocale($locale);
        // return $next($request);
        if(session()->has('locale')){
            App::setLocale(session('locale'));
        }

        return $next($request);
    }
}
