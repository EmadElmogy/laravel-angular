<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('door_id')->unsigned();
            $table->integer('advisor_id')->unsigned()->nullable();
            $table->timestamp('date');

            $table->foreign('door_id')->references('id')->on('doors')->onDelete('cascade');
            $table->foreign('advisor_id')->references('id')->on('advisors')->onDelete('set null');
        });

        Schema::create('report_products', function (Blueprint $table) {
            $table->integer('report_id')->unsigned();
            $table->integer('variation_id')->unsigned();
            $table->integer('sales');

            $table->primary(['report_id', 'variation_id'], 'report_product_pri');

            $table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');
            $table->foreign('variation_id')->references('id')->on('variations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('report_products');
        Schema::drop('reports');
    }
}
