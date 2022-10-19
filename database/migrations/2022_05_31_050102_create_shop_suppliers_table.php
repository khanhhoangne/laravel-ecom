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
        Schema::create('shop_suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_name');
            $table->string('supplier_slug');
            $table->text('description')->nullable();
            $table->string('image', 500)->nullable();
            $table->enum('status', ['Collab', 'Not collab']);
            $table->integer('position')->nullable();
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
        Schema::dropIfExists('shop_suppliers');
    }
};
