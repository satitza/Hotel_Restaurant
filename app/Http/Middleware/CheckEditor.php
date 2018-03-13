<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckEditor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->user_role != 1 && Auth::user()->user_role != 2){
            return response()->json([
                'message' => 'You don`t have administrator or editor user',
            ], 403);
        }
        return $next($request);
    }
}
