<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavdepProductCustomerMygoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('savdep_product_customer_mygoals', function (Blueprint $table) {
            $table->id();
            $table->string('sd_pc_dst_extacc', 32)->nullable()->comment('Rekening external tabungan berjangka');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->boolean('isactive')->default(true);
            $table->string('sd_pc_src_intacc', 20)->nullable()->comment('Rekening internal sumber');
            $table->string('sd_pc_dst_intacc', 20)->nullable()->comment('Rekening internal tabungan berjangka');
            $table->string('sd_pc_id', 20)->nullable()->comment('Product id');
            $table->string('sd_pc_src_extacc', 16)->nullable()->comment('Rekening external sumber');
            $table->integer('sd_pc_init_amount')->nullable()->comment('Jumlah setoran awal');
            $table->integer('sd_pc_period_amount')->nullable()->comment('Nominal setoran bulanan');
            $table->integer('sd_pc_period')->nullable()->comment('Jumlah periode autodebet');
            $table->integer('sd_pc_debet_fail_count')->default(0)->comment('Jumlah gagal debet berturut-turut. Reset menjadi 0 ketika berhasil debet normal');
            $table->integer('sd_pc_status')->default(1)->comment('1=aktif, 2=tutup normal, 3=mid-term, 4=mid-term-manual, 5=tunda; 9=aktif migrasi');
            $table->integer('sd_pc_check_flag')->default(0)->comment('0=ignore, 1=recheck autodebet, 2=penutupan rekening, 3=mid-term, 5=recheck register autodebet');
            $table->integer('sd_pc_penalty_flag')->default(0)->comment('0=ignore, 4=dikenakan biaya gagal debet');
            $table->string('sd_pc_period_date', 2)->comment('tanggal debet setiap bulannya');
            $table->integer('sd_pc_period_interval')->nullable()->comment('0=bulanan, 1=harian, 2=mingguan');
            $table->string('sd_pc_branch_reg', 4)->nullable()->comment('id branch office tempat pendaftaran');
            $table->string('sd_pc_user_reg', 10)->nullable()->comment('id user maker');
            $table->dateTime('sd_pc_reg_date')->comment('tanggal waktu registrasi');
            $table->string('sd_pc_src_name', 32)->nullable()->comment('nama pemilik rekening sumber');
            $table->string('sd_pc_dst_name', 32)->nullable()->comment('nama pemilik rekening tabungan berjangka');
            $table->date('sd_pc_dob')->comment('tanggal lahir');
            $table->string('sd_pc_gender', 1)->nullable()->comment('L=laki-laki/P=perempuan');
            $table->string('sd_pc_aim')->nullable()->comment('nama ahli waris');
            $table->string('sd_pc_notif_phone', 15)->unique()->nullable()->comment('no hp pemilik rekening tabungan berjangka');
            $table->string('sd_pc_notif_email', 64)->unique()->nullable()->comment('email pemilik rekening tabungan berjangka');
            $table->integer('sd_pc_notif_status')->default(0)->comment('0=tidak aktif, 1=aktif');
            $table->integer('sd_pc_notif_flag')->default(0)->comment('0=tidak aktif, 1=sms, 3=email, 4=sms dan email');
            $table->string('sd_pc_settle_date', 8)->nullable()->comment('YYYYMMDD, closing bulan selesai, SP_PC_REG_DATE + SP_PC_PERIOD');
            $table->string('sd_pc_validate_blth', 6)->nullable()->comment('YYYYMM, validasi apakah bulan tagihan sudah ditransfer atau belum');
            $table->string('sd_pc_cif_src', 6)->nullable();
            $table->string('sd_pc_cif_dst', 6)->nullable();
            $table->text('sd_pc_misi_utama')->nullable();
            $table->integer('sd_pc_goals_amount')->nullable();
            $table->integer('sd_pc_approval_status')->default(1);
            $table->text('sd_pc_rejected_notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('savdep_product_customer_mygoals');
    }
}
