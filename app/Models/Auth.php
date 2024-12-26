<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Role;
use App\Models\User;

class Auth extends Model
{
    protected $table        = 'auths';
    protected $primaryKey   = 'id';
    use HasFactory;

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function role(){
        return $this->hasOne(Role::class, 'id', 'role_id');
    }
}
