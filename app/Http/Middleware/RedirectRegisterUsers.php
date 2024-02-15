<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectRegisterUsers
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->getRequestUri() === '/registerusers') {
            return redirect('/register/users', 301); // 301 for permanent redirect
        }

        return $next($request);
    }
}
