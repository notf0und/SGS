<?php

namespace App\Http\Middleware;

use App\Http\Controllers\DBI\IndexController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsDbiClient
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Str::startsWith($request->userAgent() ?? '', 'DBI/')) {
            return app(IndexController::class)($request);
        }

        return $next($request);
    }
}
