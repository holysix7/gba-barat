<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavdepSchedulersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('savdep_schedulers', function (Blueprint $table) {
            $table->string('sd_s_id', 25)->unique();
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
            $table->string('sd_s_name', 255)->nullable();
            $table->string('sd_s_start_time', 5)->nullable();
            $table->string('sd_s_end_time', 5)->nullable();
            $table->text('sd_s_description')->nullable();
            $table->string('sd_s_status', 5)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('savdep_schedulers');
    }
}
