<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\Auth;

class CheckRole 
{
    /**
     * Handle an incoming request
     * 
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param String $role
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {

        $user = Auth::guard('api')->user();

        if ($user->role == 'admin') {
            return $next($request);
        } else {
            return response()->json('Unauthorized', 403);
        }
        
    }
}