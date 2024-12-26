<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_branches', function (Blueprint $table) {
            $table->id();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->boolean('isactive')->default(true);
            $table->string('code');
            $table->string('name');
            $table->string('kcp');
            $table->string('kc');
            $table->string('kanwil_ori');
            $table->string('name_kanwil_ori');
            $table->string('kanwil');
            $table->string('name_kanwil');
            $table->string('group_branch');
            $table->string('dati');
            $table->string('sandi');
            $table->string('kc_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_branches');
    }
}
