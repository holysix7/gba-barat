<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->boolean('isactive')->default(true);
            $table->string('name');
            $table->string('no_telp')->nullable();
            $table->boolean('kepala_keluarga')->default(false);
            $table->string('rt')->nullable();
            $table->integer('address_id')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('no_kk')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('status_ktp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
