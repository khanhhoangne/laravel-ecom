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
        Schema::create('shop_customers', function (Blueprint $table) {
            $table->id();
            $table->string('username', 100)->nullable();
            $table->string('password', 150);
            $table->string('fullname')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->string('email')->unique();
            $table->datetime('birthday')->nullable();
            $table->string('avatar', 500)->nullable();
            $table->string('phone', 25)->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default("Active");
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
        Schema::dropIfExists('shop_customers');
    }
};
