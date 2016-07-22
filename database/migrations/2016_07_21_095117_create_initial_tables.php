<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInitialTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('doors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id')->unsigned();
            $table->string('name');

            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
        });

        Schema::create('advisors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('door_id')->unsigned();
            $table->string('name');
            $table->string('phone');
            $table->string('username');
            $table->string('password');
            $table->tinyInteger('day_off')->unisgned();
            $table->tinyInteger('title')->unisgned();

            $table->foreign('door_id')->references('id')->on('doors')->onDelete('cascade');
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->tinyInteger('brand')->unsigned();
            $table->string('name');

            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
        });

        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->string('name');
            $table->string('image');

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });

        Schema::create('variations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->string('name');
            $table->string('barcode');

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::create('complains', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('door_id')->unsigned();
            $table->integer('advisor_id')->unsigned();
            $table->text('comment');

            $table->foreign('door_id')->references('id')->on('doors')->onDelete('cascade');
            $table->foreign('advisor_id')->references('id')->on('advisors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('complains');
        Schema::drop('variations');
        Schema::drop('products');
        Schema::drop('categories');
        Schema::drop('advisor_titles');
        Schema::drop('advisors_titles');
        Schema::drop('advisors');
        Schema::drop('doors');
        Schema::drop('sites');
    }
}
