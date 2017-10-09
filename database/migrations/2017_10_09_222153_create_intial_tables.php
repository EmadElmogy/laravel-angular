<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntialTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('contacts', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->string('email')->unique();
          $table->timestamps();
      });

      Schema::create('apartments', function (Blueprint $table) {
          $table->increments('id');
          $table->date('move_in_date');
          $table->string('street');
          $table->string('postcode');
          $table->string('town');
          $table->string('country');
          $table->integer('contact_id')->unsigned();
          $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
          $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
