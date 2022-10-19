<?php

namespace App\Http\Middleware;

use Closure;
use Error;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class VerifyJWTToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $id = $request->input('id');

        $customer = JWTAuth::User()->toArray();

        if ($id !== $customer['id']) {
           throw new Error("Forbidden", 401);
        }

        return $next($request);
    }
}