<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavdepProductCustomerRegularsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('savdep_product_customer_regulars', function (Blueprint $table) {
            $table->string('sd_pc_r_id', 32)->unique();
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
            $table->string('sd_pc_pid', 20)->nullable();
            $table->string('sd_pc_branch_reg', 4)->nullable();
            $table->string('sd_pc_user_reg', 10)->nullable();
            $table->string('sd_pc_status', 1)->nullable();
            $table->dateTime('sd_pc_reg_date')->nullable();
            $table->string('sd_pc_approval_status', 1)->nullable()->comment('0=Appoved; 1=Menunggu Approval Pendaftaran; 3=Menunggu Approval Penutupan; 4=Rejected');
            $table->text('sd_pc_rejected_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('savdep_product_customer_regulars');
    }
}
