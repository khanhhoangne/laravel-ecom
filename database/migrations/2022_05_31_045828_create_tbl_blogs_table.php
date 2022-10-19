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
        Schema::create('tbl_blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug', 300);
            $table->string('subtitle', 500);
            $table->string('thumbnail', 500);
            $table->text('content');
            $table->tinyInteger('status');
            $table->string('author')->nullable();
            $table->integer('view')->nullable();
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
        Schema::dropIfExists('tbl_blogs');
    }
};
