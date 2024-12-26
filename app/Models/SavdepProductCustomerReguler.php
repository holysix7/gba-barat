<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SavdepProductCustomerRegularDetail;

class SavdepProductCustomerRegular extends Model
{
    protected $table        = 'savdep_product_customer_reguler';
    protected $primaryKey   = 'sd_pc_r_id';
    protected $keyType      = 'string';
    public $incrementing    = false;
    public $timestamps      = false;
    use HasFactory;

    public function details(){
        return $this->hasMany(SavdepProductCustomerRegularDetail::class, 'sd_pc_r_id', 'sd_pc_r_id');
    }
}
