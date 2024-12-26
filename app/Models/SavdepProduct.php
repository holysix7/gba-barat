<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SavdepProductSpdef;

class SavdepProduct extends Model
{
    protected $table = 'savdep_product';
    protected $primaryKey   = 'sd_p_id';
    protected $keyType      = 'string';
    public $incrementing    = false;
    public $timestamps      = false;
    use HasFactory;

    // public function interest(){
    //     return $this->belongsTo(SavdepProductSpdef::class, 'sp_p_interest', 'sd_ps_implement_type');
    // }
}