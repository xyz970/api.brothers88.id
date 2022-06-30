<?php

namespace App\Http\Middleware;

use App\Http\Traits\ApiResponse;
use Closure;
use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminRole
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        JWTAuth::parseToken()->authenticate();
        $user = Auth::user();
        if ($user->role != "Super Admin") {
            return $this->internalErrorResponse("Uppsss, Anda tidak bisa mengakses ini",401);
        } else {
            return $next($request);
        }
    }
}
