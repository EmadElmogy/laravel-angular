<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Stock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variations_stock', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('variation_id')->unsigned();
            $table->integer('door_id')->unsigned();
            $table->integer('stock')->unsigned();

            $table->foreign('variation_id')->references('id')->on('variations')->onDelete('cascade');
            $table->foreign('door_id')->references('id')->on('doors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('variations_stock');
    }
}
