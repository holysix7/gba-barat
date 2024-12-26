<?php

namespace App\Models\MaterilizedViews;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MvSummaryLsbu extends Model
{
    protected $table        = 'mv_summary_lsbu';
    public $incrementing    = false;
    public $timestamps      = false;
    use HasFactory;
}
