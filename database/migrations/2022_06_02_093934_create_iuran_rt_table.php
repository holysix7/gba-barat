<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIuranRtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iuran_rt', function (Blueprint $table) {
            $table->id();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->boolean('isactive')->default(true);
            $table->date('tanggal');
            $table->string('name')->nullable();
            $table->integer('nominal')->nullable();
            $table->integer('rt_id')->nullable();
            $table->boolean('status_bayar')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iuran_rt');
    }
}
