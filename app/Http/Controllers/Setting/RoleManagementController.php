<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SysRole;
use App\Models\SysPermission;
use App\Models\SysApplication;
use App\Models\SysRolePermission;
use App\Models\SysBranch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class RoleManagementController extends Controller
{
    public function index(Request $request){
        return view('setting.role-management.index');
    }

    public function new(){
        return view('setting.role-management.index');
    }
    
    public function create(Request $request){
        $record = SysRole::batch_permissions($request);
        if($record){
            userActivities('Create', 'Menambahkan data', 'sys_roles', 'General', Route::current()->getName());
            $alert      = "success";
            $message    = "Berhasil menambahkan role!";   
        }else{
            $alert      = "danger";
            $message    = "Gagal menambahkan role!";   
        }
        return redirect()->route('setting.rolemanagement')->with([
            'message'       => $message,
            'alert-type'    => $alert
        ]);
    }

    public function update(Request $request){
        $record             = SysRole::where('id', $request->id)->first();
        $record->name       = $request->name;
        $record->isactive   = $request->isactive;

        if($record->save()){
            $attributes     = $record->getAttributes();
            $originals      = $record->getOriginal();
            $this->logActivityUpdate($attributes, $originals);
            $alert      = "success";
            $message    = "Berhasil mengubah data role!";   
        }else{
            $alert      = "danger";
            $message    = "Gagal mengubah data role!";   
        }
        return redirect()->route('setting.rolemanagement')->with([
            'message'       => $message,
            'alert-type'    => $alert
        ]);
    }

    public function access($roleId){
        $role   = SysRole::where('id', Crypt::decrypt($roleId))->first();
        return view('setting.role-management.index', compact('role'));
    }

    /**
     * AJAX
     */

    public function ajax_access_by_role(Request $request){
        if($request->role_id){
            $records        = SysRolePermission::where('role_id', $request->role_id)->orderBy('id', 'ASC')->get();
            $permissions    = SysPermission::all();
            $menus          = SysApplication::getAccessMenu($request->role_id, 2);
        }else{
            $records        = [];
            $permissions    = [];
            $menus          = [];
        }
        $response = [
            "permissions"   => $permissions,
            "menus"         => $menus,
            "data"          => $records
        ];
    
        return response()->json($response);
    }

    public function ajax_update_permission(Request $request){
        $record = SysRolePermission::where('id', $request->role_permission_id)->first();
        if($record){
            if($request->parent_id){
                $parents = SysApplication::where('parent_id', $request->parent_id)->get();
                foreach($parents as $parent){
                    if($parent->type > 0){
                        $permissions = SysPermission::all();
                        foreach($permissions as $permission){
                            $rolePermission = SysRolePermission::where([
                                ['application_id', $parent->id],
                                ['role_id', $request->role_id],
                                ['permission_id', $permission->id],
                            ])->first();
                            if($rolePermission){
                                $rolePermission->isactive = $request->checked;
                                $rolePermission->save();
                            }
                        }
                    }else{
                        $childs = SysApplication::where('parent_id', $parent->id)->get();
                        if(count($childs) > 0){
                            $permissions = SysPermission::all();
                            foreach($childs as $child){
                                foreach($permissions as $permission){
                                    $rolePermission = SysRolePermission::where([
                                        ['application_id', $child->id],
                                        ['role_id', $request->role_id],
                                        ['permission_id', $permission->id],
                                    ])->first();
                                    if($rolePermission){
                                        $rolePermission->isactive = $request->checked;
                                        $rolePermission->save();
                                    }
                                }
                            }
                        }else{
                            $rolePermission = SysRolePermission::where([
                                ['application_id', $parent->id],
                                ['role_id', $request->role_id],
                                ['permission_id', 1],
                            ])->first();
                            if($rolePermission){
                                $rolePermission->isactive = $request->checked;
                                $rolePermission->save();
                            }
                        }
                    }
                }
            }
            $record->isactive = $request->checked;
            if($record->save()){
                $message    = 'Success, berhasil melakukan update permission!';
                $rc         = '0000';
            }else{
                $message    = 'Error, ketika melakukan update permission!';
                $rc         = '0001';
            }
        }else{
            $message    = 'Error, tidak ada permission tersebut!';
            $rc         = '0002';
        }
        $application    = SysApplication::where('id', $record->application_id)->first();
        $permission     = SysPermission::where('id', $record->permission_id)->first();
        $role           = SysRole::where('id', $record->role_id)->first();
        $result = [
            "rc"            => $rc,
            "rcm"           => $message,
            "application"   => $application->name,
            "permission"    => $permission->name,
            "role"          => $role->name,
            "condition"     => $record->isactive
        ];
        return response()->json($result);
    }

    public function ajax_roles(Request $request){
        if($request->search){
            $query      = DB::table('sys_roles AS a')
                ->select('a.id', 'a.isactive', 'a.name')
                ->where('a.name', 'ilike', "%$request->search%");
            $resCount   = SysRole::where('a.name', 'ilike', "%$request->search%")
                ->count();
        }else{
            $query      = DB::table('sys_roles AS a')
                ->select('a.id', 'a.isactive', 'a.name')
                ->skip($request->start)
                ->take($request->length)
                ->orderBy('id', 'asc');
            $resCount   = SysRole::all()->count();
        }
        $result     = $query->get();
        $no         = $request->start;
        foreach($result as $row){
            $row->id        = Crypt::encrypt($row->id);
            $row->rownum    = ++$no;
        }
        $response = [
            "draw"              => $request->draw,
            "recordsTotal"      => $resCount,
            "recordsFiltered"   => $resCount,
            "data"              => $result
        ];
    
        return response()->json($response);
    }

    public function ajax_show(Request $request){
        $record = SysRole::where('id', Crypt::decrypt($request->id))->first();
        return response()->json($record);
    }

    /**
     * Log Activity
     */

    Public function logActivityUpdate($attributes, $originals){
        $originals['created_at'] = date('Y-m-d H:i:s');
        $originals['updated_at'] = date('Y-m-d H:i:s');
        
        $field = '';
        foreach($attributes as $key => $value){
            foreach($originals as $oKey => $oValue){
                if($key != 'created_at' && $oKey != 'created_at' && $key != 'updated_at' && $oKey != 'updated_at'){
                    if($key == $oKey){
                        if($value != $oValue){
                            $field = $field != '' ? $field . ', ' . $key : $field . $key;
                        }
                    }
                }
            }
        }

        userActivities('Update', 'Melakukan update pada field: ' . $field, 'sys_roles', 'General', Route::current()->getName());
    }
}