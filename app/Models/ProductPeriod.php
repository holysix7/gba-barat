<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPeriod extends Model
{
    protected $table        = 'savdep_product_period';
    protected $primaryKey   = 'sd_pp_code';
    protected $keyType      = 'string';
    public $incrementing    = false;
    public $timestamps      = false;
    use HasFactory;
}
