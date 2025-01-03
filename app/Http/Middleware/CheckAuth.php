<?php

namespace App\Http\Middleware;

use Closure;

class CheckAuth
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
        // dd(session('status'));
        if(!session('status')){
            return $this->checking();
        }
        return $next($request);
    }

    public function checking(){
        return redirect('/login');
    }
}