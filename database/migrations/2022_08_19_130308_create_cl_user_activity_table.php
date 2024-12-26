<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClUserActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cl_user_activities', function (Blueprint $table) {
            $table->string('cua_id', 25)->unique();
            $table->string('cua_act', 255)->nullable();
            $table->string('cua_desc', 255)->nullable();
            $table->string('cua_status', 255)->nullable();
            $table->string('cua_by_uid', 255)->nullable();
            $table->dateTime('cua_dt')->nullable();
            $table->string('cua_session', 255)->nullable();
            $table->string('cua_ip', 255)->nullable();
            $table->string('cua_user_agent', 255)->nullable();
            $table->string('cua_act_id', 255)->nullable();
            $table->string('cua_type', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cl_user_activity');
    }
}
