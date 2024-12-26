<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VSummaryLsbu extends Model
{
    protected $table        = 'v_summary_lsbu';
    public $incrementing    = false;
    public $timestamps      = false;
    use HasFactory;

    
    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
