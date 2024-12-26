<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavdepTransaction extends Model
{
    protected $table = 'savdep_transactions';
    protected $primaryKey   = 'sd_t_id';
    protected $keyType      = 'string';
    public $incrementing    = false;
    public $timestamps      = false;
    use HasFactory;
}
