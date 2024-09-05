<?php

namespace App\Http\Middleware;

use App\Http\Requests\Auth\RefreshRequest;
use Closure;
use DragonCode\Contracts\Cashier\Resources\AccessToken;
use Symfony\Component\HttpFoundation\Response;

class RefreshMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(RefreshRequest $request, Closure $next): Response
    {
        return $next($request);
    }
}
