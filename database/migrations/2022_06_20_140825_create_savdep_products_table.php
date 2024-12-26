<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavdepProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('savdep_products', function (Blueprint $table) {
            $table->id();
            $table->string('sp_p_id', 16)->comment('Kode product');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->string('sp_p_name', 50)->comment('Name product');
            $table->integer('sp_p_min_init_amount')->comment('Minimum setoran awal');
            $table->integer('sp_p_min_period_amount')->comment('Minimum setoran bulanan');
            $table->integer('sp_p_max_period_amount')->comment('Maximum setoran bulanan');
            $table->integer('sp_p_denom_period_amount')->nullable()->comment('Denominasi setoran bulanan');
            $table->integer('sp_p_min_period')->nullable()->comment('Minimum jangka waktu dan bulan');
            $table->integer('sp_p_max_period')->nullable()->comment('Maximum jangka waktu dan bulan');
            $table->integer('sp_p_max_period_fail')->nullable()->comment('Maximum gagal debet');
            $table->string('sp_p_period_fail_penalty', 16)->nullable()->comment('Kode skema implementasi biaya gagal debet');
            $table->string('sp_p_mid_term_penalty', 16)->nullable()->comment('Kode skema implementasi mid-termination');
            $table->string('sp_p_deposit_acc_type', 10)->nullable()->comment('Type rekening untuk tabungan berjangka');
            $table->string('sp_p_closing_scheme', 16)->nullable()->comment('Kode skema implementasi penutupan akhir periode');
            $table->string('sp_p_interest', 16)->nullable()->comment('Kode skema implementasi bunga');
            $table->string('sp_p_admin', 16)->nullable()->comment('Kode skema implementasi biaya admin');
            $table->string('sp_p_currency', 3)->nullable()->comment('IDR=Indonesia');
            $table->string('sp_p_product_status', 1)->nullable()->comment('0=tidak aktif, 1=aktif');
            $table->string('sp_p_period_fail_penalty_acc', 10)->nullable()->comment('Rekening penampungan untuk penalty gagal debet');
            $table->string('sp_p_mid_term_penalty_acc', 10)->nullable()->comment('Rekening penampungan untuk mid-termination');
            $table->string('sp_p_admin_acc', 10)->nullable()->comment('Rekening penampungan untuk biaya admin');
            $table->string('sp_p_group_account', 16)->nullable();
            $table->timestamps();
            $table->boolean('isactive')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('savdep_products');
    }
}
