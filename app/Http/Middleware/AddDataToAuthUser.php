<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
class AddDataToAuthUser
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (!session('profile_id')) {
                session()->put('profile_id', Auth::user()->profile()->first()->id);
            }
        }

        return $next($request);
    }
}
