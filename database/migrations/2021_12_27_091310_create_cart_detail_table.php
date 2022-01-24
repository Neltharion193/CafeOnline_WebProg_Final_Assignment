<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cart_header_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedInteger('quantity');
            $table->foreign('cart_header_id')->references('id')->on('cart_headers')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('cart_details');
    }
}
