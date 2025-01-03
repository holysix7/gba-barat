<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\SysRolePermission;
use App\Models\SysApplication;

class CheckPermission
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
        if(!session('status')){
            return $this->checking();
        }
        // dd(request()->segment(1));
        return $next($request);
    }

    public function checking(){
        return redirect('/login');
    }
}