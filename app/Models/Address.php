<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Role;

class Address extends Model
{
    protected $table        = 'address';
    protected $primaryKey   = 'id';
    use HasFactory;

}
