<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SysRole;

class SysUser extends Model
{
    protected $table        = 'sys_users';
    protected $primaryKey   = 'id';
    protected $keyType      = 'string';
    public $incrementing    = false;
    public $timestamps      = false;
    use HasFactory;

    public function role(){
        return $this->hasOne(SysRole::class, 'id', 'role_id');
    }

    public function branch(){
        return $this->hasOne(SysBranch::class, 'kc', 'kodeCabang');
    }
}
