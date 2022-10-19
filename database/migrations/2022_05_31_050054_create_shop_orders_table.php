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
        Schema::create('shop_orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_id')->unsigned();
            $table->bigInteger('customer_id')->unsigned();
            $table->dateTime('order_date', 0);
            $table->dateTime('shipped_date', 0)->nullable();
            $table->text('order_note')->nullable();
            $table->bigInteger('address_id')->unsigned();
            $table->decimal('shipping_fee', 8, 2);
            $table->bigInteger('payment_type_id')->unsigned();
            $table->date('paid_date')->nullable();
            $table->tinyInteger('order_status');
            $table->timestamps();
            $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('shop_customers')->onDelete('cascade');
            $table->foreign('address_id')->references('id')->on('shop_customer_address')->onDelete('cascade');
            $table->foreign('payment_type_id')->references('id')->on('shop_payment_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_orders');
    }
};
