<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string[] ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $userRole = Auth::user()->role;
            $url = $request->path();

            // If the URL contains 'admin' and the role is not allowed
            if (stripos($url, 'admin') !== false && !in_array($userRole, $roles)) {
                Auth::logout();
                return redirect()->route('user.login')->with('status', 'You are not authorized to access this page.');
            }

            // Check if the user's role is one of the allowed roles
            if (in_array($userRole, $roles)) {
                return $next($request);
            }

            // If role doesn't match, log out the user and redirect based on their role
            Auth::logout();
            if ($userRole === 'user') {
                return redirect()->route('user.login')->with('status', 'You are not authorized to access this page.');
            }

            // Add more conditions for different roles if needed
        }

        // Default redirection for non-authenticated users
        return redirect()->route('user.login')->with('status', 'Please log in to access this page.');
    }
}
