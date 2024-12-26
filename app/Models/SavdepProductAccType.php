<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SavdepGroupAccountType;

class SavdepProductAccType extends Model
{
    protected $table        = 'savdep_product_acc_type';
    protected $primaryKey   = 'sd_pat_pid';
    protected $keyType      = 'string';
    public $incrementing    = false;
    public $timestamps      = false;
    use HasFactory;

    public function group_type(){
        return $this->hasOne(SavdepGroupAccountType::class, 'sd_gat_aid', 'sd_pat_pid');
    }
}