<?php

namespace App\Models\MaterilizedViews;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MvSummaryMygoals extends Model
{
    protected $table        = 'mv_summary_mygoals';
    public $incrementing    = false;
    public $timestamps      = false;
    use HasFactory;
}
