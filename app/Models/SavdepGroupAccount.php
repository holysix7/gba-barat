<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavdepGroupAccount extends Model
{
    protected $table        = 'savdep_group_account';
    protected $primaryKey   = 'sd_ga_id';
    protected $keyType      = 'string';
    public $incrementing    = false;
    public $timestamps      = false;
    use HasFactory;
}
