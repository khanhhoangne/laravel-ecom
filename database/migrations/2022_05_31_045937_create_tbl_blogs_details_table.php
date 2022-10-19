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
        Schema::create('tbl_blogs_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('blog_id')->unsigned();
            $table->bigInteger('cate_id')->unsigned();
            $table->timestamps();
            $table->foreign('blog_id')->references('id')->on('tbl_blogs')->onDelete('cascade');
            $table->foreign('cate_id')->references('id')->on('tbl_blogs_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_blogs_details');
    }
};
