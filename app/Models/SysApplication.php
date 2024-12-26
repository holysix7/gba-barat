<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SysRolePermission;
use App\Models\SysApplicationChild;
use \DB;

class SysApplication extends Model
{
    protected $table = 'sys_applications';
    use HasFactory;

    public function childs(){
        return $this->hasMany(SysApplicationChild::class, 'parent_id', 'id');
    }
    
    public static function getAccessMenu($roleId, $type){
        $parentsHaventChilds    = SysApplication::where([
            ['type', 3],
            ['parent_id', 0],
            ['isactive', true]
        ])->orderBy('orders', 'asc')->get();
        $parents                = SysApplication::where([
            ['type', 0],
            ['parent_id', 0],
            ['isactive', true]
        ])->orderBy('orders', 'asc')->get();
        $childs                 = SysApplication::where([
            ['parent_id', '<>', 0],
            ['isactive', '=', true]
        ])->orderBy('orders', 'asc')->get();
        $grandChilds            = SysApplication::where([
            ['type', '=', 2],
            ['parent_id', '<>', 0],
            ['isactive', '=', true]
        ])->orderBy('orders', 'asc')->get();
        $records    = [];
        foreach($parentsHaventChilds as $parentsHaventChild){
            foreach($parentsHaventChild->rPermissions as $rPermissionPHC){
                if($rPermissionPHC->role_id == $roleId){
                    if($rPermissionPHC->permission->description == 'read'){
                        if($type == 1){
                            if($rPermissionPHC->isactive == true){
                                $rowParent = [
                                    'id'            => $parentsHaventChild->id,
                                    'isactive'      => $parentsHaventChild->isactive,
                                    'name'          => $parentsHaventChild->name,
                                    'slug'          => $parentsHaventChild->slug,
                                    'description'   => $parentsHaventChild->description,
                                    'icon'          => $parentsHaventChild->icon,
                                    'order'         => $parentsHaventChild->orders,
                                    'type'          => $parentsHaventChild->type,
                                    'childs'        => []
                                ];
                                array_push($records, $rowParent);
                            }
                        }else{
                            $rowParent = [
                                'id'            => $parentsHaventChild->id,
                                'isactive'      => $parentsHaventChild->isactive,
                                'name'          => $parentsHaventChild->name,
                                'slug'          => $parentsHaventChild->slug,
                                'description'   => $parentsHaventChild->description,
                                'icon'          => $parentsHaventChild->icon,
                                'order'         => $parentsHaventChild->orders,
                                'type'          => $parentsHaventChild->type,
                                'childs'        => []
                            ];
                            array_push($records, $rowParent);
                        }
                    }
                }
            }
        }
        foreach($parents as $parent){
            $rowChild = [];
            foreach($childs as $child){
                $rowGrandChild = [];
                foreach($grandChilds as $grandChild){
                    foreach($grandChild->rPermissions as $rPermissionGrandChild){
                        if($rPermissionGrandChild->role_id == $roleId){
                            if($rPermissionGrandChild->permission->description == 'read'){
                                if($type == 1){
                                    if($rPermissionGrandChild->isactive == true){
                                        if($child->id == $grandChild->parent_id){
                                            $rowGchild = [
                                                'id'            => $grandChild->id,
                                                'isactive'      => $grandChild->isactive,
                                                'name'          => $grandChild->name,
                                                'slug'          => $grandChild->slug,
                                                'description'   => $grandChild->description,
                                                'icon'          => $grandChild->icon,
                                                'order'         => $grandChild->orders,
                                                'type'          => $grandChild->type,
                                                'parent_id'     => $grandChild->parent_id
                                            ];
                                            array_push($rowGrandChild, $rowGchild);
                                        }
                                    }
                                }else{
                                    if($child->id == $grandChild->parent_id){
                                        $rowGchild = [
                                            'id'            => $grandChild->id,
                                            'isactive'      => $grandChild->isactive,
                                            'name'          => $grandChild->name,
                                            'slug'          => $grandChild->slug,
                                            'description'   => $grandChild->description,
                                            'icon'          => $grandChild->icon,
                                            'order'         => $grandChild->orders,
                                            'type'          => $grandChild->type,
                                            'parent_id'     => $grandChild->parent_id
                                        ];
                                        array_push($rowGrandChild, $rowGchild);
                                    }
                                }
                            }
                        }
                    }
                }
                foreach($child->rPermissions as $rPermission){
                    if($rPermission->role_id == $roleId){
                        if($rPermission->permission->description == 'read'){
                            if($type == 1){
                                if($rPermission->isactive == true){
                                    if($parent->id == $child->parent_id){
                                        $row = [
                                            'id'            => $child->id,
                                            'isactive'      => $child->isactive,
                                            'name'          => $child->name,
                                            'slug'          => $child->slug,
                                            'description'   => $child->description,
                                            'icon'          => $child->icon,
                                            'order'         => $child->orders,
                                            'type'          => $child->type,
                                            'parent_id'     => $child->parent_id,
                                            'grand_childs'  => $rowGrandChild
                                        ];
                                        array_push($rowChild, $row);
                                    }
                                }
                            }else{
                                if($parent->id == $child->parent_id){
                                    $row = [
                                        'id'            => $child->id,
                                        'isactive'      => $child->isactive,
                                        'name'          => $child->name,
                                        'slug'          => $child->slug,
                                        'description'   => $child->description,
                                        'icon'          => $child->icon,
                                        'order'         => $child->orders,
                                        'type'          => $child->type,
                                        'parent_id'     => $child->parent_id,
                                        'grand_childs'  => $rowGrandChild
                                    ];
                                    array_push($rowChild, $row);
                                }
                            }
                        }
                    }
                }
            }
            foreach($parent->rPermissions as $rPermission){
                if($rPermission->role_id == $roleId){
                    if($rPermission->permission->description == 'read'){
                        if($type == 1){
                            if($rPermission->isactive == true){
                                $rowParent = [
                                    'id'            => $parent->id,
                                    'isactive'      => $parent->isactive,
                                    'name'          => $parent->name,
                                    'slug'          => $parent->slug,
                                    'description'   => $parent->description,
                                    'icon'          => $parent->icon,
                                    'order'         => $parent->orders,
                                    'type'          => $parent->type,
                                    'childs'        => $rowChild
                                ];
                                array_push($records, $rowParent);
                            }
                        }else{
                            $rowParent = [
                                'id'            => $parent->id,
                                'isactive'      => $parent->isactive,
                                'name'          => $parent->name,
                                'slug'          => $parent->slug,
                                'description'   => $parent->description,
                                'icon'          => $parent->icon,
                                'order'         => $parent->orders,
                                'type'          => $parent->type,
                                'childs'        => $rowChild
                            ];
                            array_push($records, $rowParent);
                        }
                    }
                }
            }
        }
        return $records;
    }

    public function rPermissions(){
        return $this->hasMany(SysRolePermission::class, 'application_id', 'id');
    }
}