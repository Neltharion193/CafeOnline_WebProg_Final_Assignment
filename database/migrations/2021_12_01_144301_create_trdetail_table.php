<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrdetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('header_transaction_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedInteger('quantity');
            $table->foreign('header_transaction_id')->references('id')->on('tr_headers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_id')->references('id')->on('ms_products')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tr_details');
    }
}
