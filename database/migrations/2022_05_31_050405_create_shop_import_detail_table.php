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
        Schema::create('shop_import_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('import_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->string('product_option', 50)->comment('Save as option_id,option_id')->nullable();
            $table->integer('quantity');
            $table->decimal('unit_price', 19, 4);
            $table->timestamps();
            $table->foreign('import_id')->references('id')->on('shop_imports')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('shop_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_import_detail');
    }
};
