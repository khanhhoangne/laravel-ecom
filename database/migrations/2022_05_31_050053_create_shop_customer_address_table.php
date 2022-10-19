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
        Schema::create('shop_customer_address', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->unsigned();
            $table->string('address', 500);
            $table->integer('ward_id');
            $table->integer('district_id');
            $table->integer('province_id');
            $table->boolean('is_default')->default(false);
            $table->string('postal_code', 15)->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('shop_address');
    }
};
