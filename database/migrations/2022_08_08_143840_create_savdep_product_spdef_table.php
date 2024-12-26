<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavdepProductSpdefTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('savdep_product_spdef', function (Blueprint $table) {
            $table->string('sd_ps_abstract_type', 4)->unique()->comment('kode skema rumus');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->string('sd_ps_implement_type', 4)->nullable()->comment('kode tipe skema');
            $table->string('sd_ps_param_scheme', 16)->nullable()->comment('kode skema parameter untuk proses implementasi');;
            $table->string('sd_ps_formula_from_account', 16)->nullable()->comment('rumus dari skema');
            $table->string('sd_ps_value_type', 1)->nullable()->comment('0=numeric; 1=string');
            $table->string('sd_ps_variable', 32)->nullable()->comment('parameter dan nilai untuk rumus');
            $table->string('sd_ps_to_account', 32)->nullable()->comment('rekening tujuan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('savdep_product_spdef');
    }
}
