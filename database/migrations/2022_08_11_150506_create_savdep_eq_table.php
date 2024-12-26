<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavdepEqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('savdep_eq', function (Blueprint $table) {
            $table->string('sd_e_id', 25)->unique();
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
            $table->string('sd_e_name', 255)->nullable();
            $table->string('sd_e_merchant_code', 50)->nullable();
            $table->string('sd_e_debit_code', 50)->nullable();
            $table->string('sd_e_credit_code', 50)->nullable();
            $table->string('sd_e_audit_id', 50)->nullable();
            $table->string('sd_e_branch_code', 50)->nullable();
            $table->string('sd_e_supervisor_user', 50)->nullable();
            $table->string('sd_e_supervisor_password', 50)->nullable();
            $table->string('sd_e_authority_user', 50)->nullable();
            $table->string('sd_e_authority_password', 50)->nullable();
            $table->string('sd_e_description', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('savdep_eq');
    }
}
