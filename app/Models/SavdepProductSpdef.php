<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SavdepSubprocessDefCode;

class SavdepProductSpdef extends Model
{
    protected $table        = 'savdep_product_spdef';
    protected $primaryKey   = 'sd_ps_abstract_type';
    protected $keyType      = 'string';
    public $incrementing    = false;
    public $timestamps      = false;
    use HasFactory;

    public function subprocess(){
        return $this->hasOne(SavdepSubprocessDefCode::class, 'sd_sdc_code', 'sd_ps_implement_type');
    }
}
