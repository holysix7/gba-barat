<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewSourceMyGoals extends Model
{
    protected $table        = 'v_source_mygoals';
    public $incrementing    = false;
    public $timestamps      = false;
    use HasFactory;

    
    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}