<?php

namespace App\Models\MaterilizedViews;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MvTransactionLsbu extends Model
{
    protected $table        = 'mv_transaction_lsbu';
    public $incrementing    = false;
    public $timestamps      = false;
    use HasFactory;
}