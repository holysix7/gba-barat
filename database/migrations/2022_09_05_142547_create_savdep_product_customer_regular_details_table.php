<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavdepProductCustomerRegularDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('savdep_product_customer_regular_details', function (Blueprint $table) {
            $table->string('sd_pc_rd_id', 32)->unique();
            $table->string('sd_pc_r_id', 32);
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
            $table->string('sd_pc_src_intacc', 32)->nullable();
            $table->string('sd_pc_src_extacc', 32)->nullable();
            $table->string('sd_pc_src_name', 32)->nullable();
            $table->string('sd_pc_cif_src', 32)->nullable();
            $table->string('sd_pc_src_gender', 1)->nullable()->comment('L=Laki-laki; P=Perempuan');
            $table->date('sd_pc_src_dob')->nullable();
            $table->string('sd_pc_src_notif_phone', 15)->nullable();
            $table->string('sd_pc_src_notif_email', 64)->nullable();
            $table->string('sd_pc_src_notif_status', 1)->nullable()->comment('0=tidak aktif; 1=aktif (kirim notif)');
            $table->string('sd_pc_src_notif_flag', 1)->nullable()->comment('0=tidak aktif; 1=sms; 3=email; 4=sms & email');
            $table->string('sd_pc_dst_intacc', 32)->nullable();
            $table->string('sd_pc_dst_extacc', 32)->nullable();
            $table->string('sd_pc_dst_name', 32)->nullable();
            $table->string('sd_pc_dst_gender', 1)->nullable()->nullable()->comment('L=Laki-laki; P=Perempuan');
            $table->date('sd_pc_dst_dob')->nullable();
            $table->string('sd_pc_cif_dst', 32)->nullable();
            $table->integer('sd_pc_period')->nullable();
            $table->integer('sd_pc_period_amount')->nullable();
            $table->string('sd_pc_period_date', 2)->nullable()->comment('tanggal debet setiap bulannya');
            $table->string('sd_pc_check_flag', 1)->nullable()->comment('0=Ignore; 1=Flag untuk recheck auto-debet; 2=Flag untuk Tutup Normal; 3=Flag untuk Mid-Term; 5:Flag untuk recheck register autodebet');
            $table->string('sd_pc_status', 1)->nullable()->comment('1= Aktif; 2=Tutup Normal; 3=Mid-Term; 4=Mid-Term Manual (via user); 5=Tunda; 9=Aktif Migrasi');
            $table->string('sd_pc_validate_blth', 6)->nullable()->comment('Validasi apakah bulan tagihan sudah ditransfer atau belum, format: YYYYMM');
            $table->string('sd_pc_settledate', 8)->nullable()->comment('Tanggal Settlement. yyyyMMdd (ClosingBulan selesai, SP_PC_REG_DATE + SP_PC_PERIOD)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('savdep_product_customer_regular_details');
    }
}
