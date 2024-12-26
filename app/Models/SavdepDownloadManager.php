<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavdepDownloadManager extends Model
{
    protected $table        = 'savdep_download_manager';
    public $incrementing    = false;
    public $timestamps      = false;
    use HasFactory;
}
