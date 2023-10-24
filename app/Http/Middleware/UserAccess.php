<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController as Level;
use Symfony\Component\HttpFoundation\Response;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $userType): Response
    {
        // Separate user level access from routes
        $userType = explode('|', $userType);

        // Divide user level from routes and actual level user, and get the same level only
        $level = Arr::only(Level::levelToArray(), $userType);

        // Check if user level is exists in group level role and redirect
        if (array_key_exists(auth()->user()->level, $level)) {
            return $next($request);
        }

        return response()->json(['Anda tidak memiliki izin untuk mengakses halaman ini.']);
    }
}
