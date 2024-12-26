<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavdepProductSpdefAccbankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('savdep_product_spdef_accbank', function (Blueprint $table) {
            $table->string('sd_psa_type', 10)->unique();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->string('sd_psa_implement_type', 4);
            $table->string('sd_psa_int_acc', 20);
            $table->integer('sd_psa_status')->default(1)->comment('0: Tidak Aktif; 1: Aktif');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('savdep_product_spdef_accbank');
    }
}
