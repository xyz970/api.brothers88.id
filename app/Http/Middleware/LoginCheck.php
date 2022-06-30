<?php

namespace App\Http\Middleware;

use App\Http\Traits\ApiResponse;
use Closure;
use JWTAuth;
use Exception;
use Illuminate\Http\Request;

class LoginCheck
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
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return $this->internalErrorResponse("Invalid token",);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return $this->internalErrorResponse("Token Expired");
            }else{
                return $this->internalErrorResponse("Token Not found");
            }
        }
        return $next($request);
    }
}
