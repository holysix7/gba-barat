<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VKantorWilayah extends Model
{
    protected $table        = 'v_kantor_wilayah';
    public $incrementing    = false;
    public $timestamps      = false;
    use HasFactory;

    
    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}