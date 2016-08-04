<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaAttendance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('door_id')->unsigned();
            $table->integer('advisor_id')->unsigned()->nullable();
            $table->timestamp('login_time');
            $table->timestamp('logout_time')->nullable();

            $table->foreign('door_id')->references('id')->on('doors')->onDelete('cascade');
            $table->foreign('advisor_id')->references('id')->on('advisors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('attendance');
    }
}
