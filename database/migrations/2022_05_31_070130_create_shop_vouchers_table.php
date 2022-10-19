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
        Schema::create('shop_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_code');
            $table->string('voucher_name');
            $table->string('voucher_slug');
            $table->text('description')->nullable();
            $table->integer('uses')->nullable();
            $table->integer('max_uses');
            $table->integer('max_uses_user');
            $table->enum('voucher_type', ['Money', 'Percent']);
            $table->float('discount_value');
            $table->datetime('start_date');
            $table->datetime('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_vouchers');
    }
};
