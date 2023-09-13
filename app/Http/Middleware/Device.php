<?php

namespace App\Http\Middleware;

use App\Services\UserDeviceService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use hisorange\BrowserDetect\Parser as Browser;

class Device
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userDeviceService = new UserDeviceService($request->user(), Browser::userAgent());

        return $userDeviceService->checkTempToken() || $userDeviceService->checkTooManyDevices() ? response(null, 403) : $next($request);
    }
}
