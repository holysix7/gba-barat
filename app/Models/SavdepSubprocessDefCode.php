<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavdepSubprocessDefCode extends Model
{
    protected $table        = 'savdep_subprocess_def_code';
    protected $primaryKey   = 'sd_sdc_code';
    protected $keyType      = 'string';
    public $incrementing    = false;
    public $timestamps      = false;
    use HasFactory;
}
