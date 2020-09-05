<?php

namespace Canvas\Http\Middleware;

use Canvas\Models\User;
use Closure;
use Illuminate\Http\Request;

class Admin
{
    /**
     * Handle the incoming request.
     *
     * @param $request
     * @param $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $request->user()->role === User::ADMIN ? $next($request) : abort(403);
    }
}
