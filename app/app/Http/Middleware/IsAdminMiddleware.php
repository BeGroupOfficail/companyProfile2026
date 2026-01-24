<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdminMiddleware

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
        if (Auth::check()){
            if(Auth::user()->is_admin == 1 && Auth::user()->status=='active'){
                return $next($request);
            }else{
               abort(403);
            }
        }else{
            return redirect('/dashboard/login');
        }
    }
}
