<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavdepSubprocessDefCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('savdep_subprocess_def_codes', function (Blueprint $table) {
            $table->string('sd_sdc_code', 4)->unique()->comment('kode skema implementasi');
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
            $table->string('sd_sdc_status', 1)->nullable()->comment('0: tidak aktif; 1:aktif');
            $table->string('sd_sdc_desc', 10)->nullable()->comment('kode deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('savdep_subprocess_def_codes');
    }
}
