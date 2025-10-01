<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if JWT token exists in cookie
        $token = $request->cookie('admin_jwt_token');
        
        if (!$token) {
            return redirect()->route('admin.login')->with('error', 'Bu sayfaya erişmek için admin girişi yapmalısınız.');
        }

        return $next($request);
    }
}
