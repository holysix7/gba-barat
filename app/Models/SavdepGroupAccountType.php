<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SavdepProductAccType;

class SavdepGroupAccountType extends Model
{
    protected $table        = 'savdep_group_account_type';
    protected $primaryKey   = null;
    protected $keyType      = null;
    public $incrementing    = false;
    public $timestamps      = false;
    use HasFactory;

    public function acc_type(){
        return $this->hasOne(SavdepProductAccType::class, 'sd_pat_pid', 'sd_gat_aid');
    }
}