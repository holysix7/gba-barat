<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewSourceLsbu extends Model
{
    protected $table        = 'v_source_lsbu';
    public $incrementing    = false;
    public $timestamps      = false;
    use HasFactory;
}
