<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavdepTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('savdep_transactions', function (Blueprint $table) {
            $table->string('sd_t_id', 32)->unique();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->boolean('isactive')->default(true);
            $table->string('sd_t_cif', 16)->nullable();
            $table->string('sd_t_src_acc', 20)->nullable();
            $table->string('sd_t_dep_acc', 20)->nullable();
            $table->string('sd_t_pid_acc', 16)->nullable();
            $table->integer('sd_t_period')->nullable();
            $table->string('sd_t_blth', 6)->nullable();
            $table->dateTime('sd_t_dt')->nullable();
            $table->string('sd_t_settle_date', 6)->nullable();
            $table->integer('sd_t_amount')->default(0);
            $table->string('sd_t_zlref', 32)->nullable();
            $table->string('sd_t_rc', 4)->nullable();
            $table->text('sd_t_message_id')->nullable();
            $table->integer('sd_t_status')->default(0)->comment('0=Gagal, 1=Sukses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('savdep_transactions');
    }
}
