<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SysApplication;
use \DB;

class SysApplicationChild extends Model
{
    protected $table = 'sys_applications';
    use HasFactory;
    
    public function parent(){
        return $this->belongsTo(SysApplication::class, 'id', 'parent_id');
    }

    public function grandChilds(){
        return $this->hasMany(SysApplicationChild::class, 'parent_id', 'id');
    }
}