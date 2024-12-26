<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SavdepProductSpdef;

class SavdepLsbuUpdate extends Model
{
    protected $table = 'savdep_lsbu_update';
    protected $primaryKey   = 'sd_pc_dst_extacc';
    protected $keyType      = 'string';
    public $incrementing    = false;
    public $timestamps      = false;
    use HasFactory;
}