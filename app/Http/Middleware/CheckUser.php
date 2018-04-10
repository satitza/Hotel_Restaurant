<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->user_role != 4) {
            /*return response()->json([
                'message' => 'You don`t have permission'
            ], 403);*/
            return new Response(view('error.index')->with('error', 'You don`t have permission'));
        }
        return $next($request);
    }
}
