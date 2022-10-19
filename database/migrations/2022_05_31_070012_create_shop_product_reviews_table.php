<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_product_reviews', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('customer_id')->unsigned();
            $table->float('rating')->nullable();
            $table->text('comment');
            $table->enum('status', ['Display', 'Undisplay']);
            $table->bigInteger('parent_id')->nullable();
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('shop_products')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('shop_customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_product_reviews');
    }
};
