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
        if(request()->segment(1)){
            if(request()->segment(1) != 'tidak-punya-akses' && request()->segment(1) != 'logout'){
                $getCondition = SysApplication::where('slug', request()->segment(1))->first();
                
                if($getCondition->childs){
                    foreach($getCondition->childs as $child){
                        if(request()->segment(2) == $child->slug){
                            foreach($child->grandChilds as $grandChild){
                                if(request()->segment(3) == $grandChild->slug){
                                    //Form Halaman
                                    if(request()->segment(4) == 'new'){
                                        $permission = SysRolePermission::where([
                                            'application_id'    => $grandChild->id,
                                            'role_id'           => session('role')->id,
                                            'permission_id'     => 2
                                        ])->first();
                                        
                                        if($permission->isactive){
                                            return $next($request);
                                        }else{
                                            return redirect(route('havent-permission', [$grandChild->name, 'tambah']));
                                        }
                                    }
                                }
                            }
                            //Form Halaman
                            if(request()->segment(3) == 'new'){
                                $permission = SysRolePermission::where([
                                    'application_id'    => $child->id,
                                    'role_id'           => session('role')->id,
                                    'permission_id'     => 2
                                ])->first();
                                
                                if($permission->isactive){
                                    return $next($request);
                                }else{
                                    return redirect(route('havent-permission', [$child->name, 'tambah']));
                                }
                            }
                            // dd($child);
                        }
                    }
                    
                    //Melihat Halaman
                    if(request()->segment(1) == $getCondition->slug){
                        $permission = SysRolePermission::where([
                            'application_id'    => $getCondition->id,
                            'role_id'           => session('role')->id,
                            'permission_id'     => 1
                        ])->first();
                        if($permission->isactive){
                            return $next($request);
                        }else{
                            return redirect(route('havent-permission', [$child->name, null]));
                        }
                    }
                    foreach($getCondition->childs as $child){
                        //Melihat Halaman
                        $permission = SysRolePermission::where([
                            'application_id'    => $child->id,
                            'role_id'           => session('role')->id,
                            'permission_id'     => 1
                        ])->first();
                        if($permission->isactive){
                            return $next($request);
                        }else{
                            return redirect(route('havent-permission', [$child->name, null]));
                        }
                        if(request()->segment(2) == $child->slug){
                            foreach($child->grandChilds as $grandChild){
                                if(request()->segment(3) == $grandChild->slug){
                                    //Melihat Halaman
                                    $permission = SysRolePermission::where([
                                        'application_id'    => $grandChild->id,
                                        'role_id'           => session('role')->id,
                                        'permission_id'     => 1
                                    ])->first();
                                    if($permission->isactive){
                                        return $next($request);
                                    }else{
                                        return redirect(route('havent-permission', [$child->name, null]));
                                    }
                                }
                            }
                        }
                    }
                }                
            }else{
                return $next($request);
            }
        }else{
            return $next($request);
        }
    }

    public function checking(){
        return redirect('/login');
    }
}