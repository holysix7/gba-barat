<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavdepProductCustomerMyGoalTemp extends Model
{
    protected $table        = 'savdep_product_customer_mygoals_temp';
    protected $primaryKey   = 'sd_pc_src_intacc';
    protected $keyType      = 'string';
    public $incrementing    = false;
    public $timestamps      = false;
    use HasFactory;
    
    public function product(){
        return $this->hasOne(SavdepProduct::class, 'sp_p_id', 'sd_pc_pid');
    }

    public function transactions(){
        return $this->hasMany(SavdepTransaction::class, 'sd_t_dep_acc', 'sd_pc_dst_extacc');
    }

    public function getSuccess(){
        $counted = SavdepTransaction::where('sd_t_status', 1)->count();
        return $counted;
    }

    public function getFail(){
        $counted = SavdepTransaction::where('sd_t_status', 0)->count();
        return $counted;
    }
}
