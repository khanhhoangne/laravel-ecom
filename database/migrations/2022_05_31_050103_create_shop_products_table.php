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
        Schema::create('shop_products', function (Blueprint $table) {
            $table->id();
            $table->string('product_code')->unique();
            $table->string('product_name');
            $table->string('product_slug');
            $table->string('image', 500);
            $table->string('short_description', 500)->nullable();
            $table->text('description')->nullable();
            $table->enum('is_continued', ['Continued', 'Discontinued']);
            $table->enum('is_featured', ['Featured', 'Not featured'])->nullable();
            $table->enum('is_new', ['New', 'Not new'])->nullable();
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('supplier_id')->unsigned();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('shop_categories')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('shop_suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_products');
    }
};
