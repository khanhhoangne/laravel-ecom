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
        Schema::create('tbl_blogs_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('slug');
            $table->string('banner', 500)->nullable();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->tinyInteger('status');
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
        Schema::dropIfExists('tbl_blogs_categories');
    }
};
