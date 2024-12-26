<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SavdepProductCustomerRegular;

class SavdepProductCustomerRegularDetail extends Model
{
    protected $table        = 'savdep_product_customer_reguler_detail';
    protected $primaryKey   = 'sd_pc_rd_id';
    protected $keyType      = 'string';
    public $incrementing    = false;
    public $timestamps      = false;
    use HasFactory;
    
    public function regular(){
        return $this->belongsTo(SavdepProductCustomerRegular::class, 'sd_pc_r_id', 'sd_pc_r_id');
    }
}
