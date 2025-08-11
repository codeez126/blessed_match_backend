<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class SuperAdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and has type 1 (admin) or type 2 (super admin)
        if (auth()->check() && (auth()->user()->type == '1' || auth()->user()->type == '2')) {
            return $next($request);
        }

        return redirect()->route('adminlogin')->with('error', 'You do not have permission to access this page!');
    }
}
