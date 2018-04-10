<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CheckReport
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
        if(Auth::user()->user_role != 1 && Auth::user()->user_role != 3){
            /*return response()->json([
                'message' => 'You don`t have administrator or report user',
            ], 403);*/
            return new Response(view('error.index')->with('error', 'You don`t have administrator or report user'));
        }

        return $next($request);
    }
}
