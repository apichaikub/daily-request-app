<?php

namespace App\Http\Middleware;

use App\Models\ClientRequest;
use Closure;

class Log
{
    public function handle($request, Closure $next)
    {
        ClientRequest::create([
            'ip' => $request->ip(),
            'method' => $request->method(),
            'path' => $request->path(),
        ]);

        return $next($request);
    }
}
