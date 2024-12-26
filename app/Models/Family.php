<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    protected $table = 'families';
    protected $primaryKey   = 'id';
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}