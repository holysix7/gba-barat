<?php

namespace App\Models\MaterilizedViews;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MvClosingSummaryLsbu extends Model
{
    protected $table        = 'mv_closing_lsbu';
    public $incrementing    = false;
    public $timestamps      = false;
    use HasFactory;

    
    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
