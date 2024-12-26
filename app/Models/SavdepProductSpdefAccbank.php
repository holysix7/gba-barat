<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SavdepSubprocessDefCode;

class SavdepProductSpdefAccbank extends Model
{
    protected $table        = 'savdep_product_spdef_accbank';
    protected $primaryKey   = 'sd_psa_type';
    protected $keyType      = 'string';
    public $incrementing    = false;
    public $timestamps      = false;
    use HasFactory;

    public function subprocess(){
        return $this->hasOne(SavdepSubprocessDefCode::class, 'sd_sdc_code', 'sd_psa_implement_type');
    }
}
