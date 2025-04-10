<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Actions\Logout;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();

            // Check if the user's account has been disabled
            if ($user->status === '0') {
                // Log the user out
                (new Logout)();

                // Redirect to user login with an error message
                return redirect()->route('user.login')->with('status', 'Your account has been disabled by our admin. Please contact us for more information.');
            }
        }

        return $next($request);
    }
}
