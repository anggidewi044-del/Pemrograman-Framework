<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class ForceHttpsScheme
{
    public function handle(Request $request, Closure $next): Response
    {
        if (app()->environment('production')
            || str_ends_with($request->getHost(), '.up.railway.app')) {
            URL::forceScheme('https');
        }

        return $next($request);
    }
}
