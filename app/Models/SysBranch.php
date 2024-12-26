<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SysRole;

class SysBranch extends Model
{
    protected $table = 'sys_branches';
    use HasFactory;

    public function role(){
        return $this->belongsTo(SysRole::class, 'id', 'branch_id');
    }
}
