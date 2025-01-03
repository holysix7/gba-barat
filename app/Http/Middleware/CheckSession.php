<?php

namespace App\Http\Middleware;

use Closure;

class CheckSession
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
        if(session('status')){
            return $this->checking();
        }
        return $next($request);
    }
    
    public function checking(){
        if(strtolower(session('user')->name) == 'lsbu'){
            $url = '/autodebit/lsbu/daftar-rekening';
        }else{
            $url = '/autodebit/my-goals/daftar-rekening';
        }
        return redirect($url);
    }
}