<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewFeeLsbu extends Model
{
    protected $table        = 'v_fee_lsbu';
    public $incrementing    = false;
    public $timestamps      = false;
    use HasFactory;
}
