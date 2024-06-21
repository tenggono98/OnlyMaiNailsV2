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
     */
    public function handle(Request $request, Closure $next, ...$roles){
        // foreach ($roles as $role) {
        //     if (Auth::check() && Auth::user()->role == $role) {
        //         return $next($request);
        //     }
        // }
        // Auth::logout();
        // return redirect()->route('login')->with('status','You are not authorized to access this page.');

        if (Auth::check()) {
            $userRole = Auth::user()->role;

            // Check if the user's role is one of the allowed roles
            if (in_array($userRole, $roles)) {
                return $next($request);
            }

            // If role doesn't match, log out the user
            Auth::logout();

            // Redirect based on the user's role
            if ($userRole === 'user') {
                return redirect()->route('user.login')->with('status', 'You are not authorized to access this page.');
            }

            // Add more conditions for different roles if needed
        }

        // Default redirection for non-authenticated users
        return redirect()->route('user.login')->with('status', 'Please log in to access this page.');
    }
}
