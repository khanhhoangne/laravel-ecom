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
        Schema::create('tbl_blogs_comments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('blog_id')->unsigned();
            $table->bigInteger('customer_id')->unsigned();
            $table->text('content');
            $table->tinyInteger('comment_status')->default(1);
            $table->bigInteger('parent_id')->nullable();
            $table->timestamps();
            $table->foreign('blog_id')->references('id')->on('tbl_blogs')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_blogs_comments');
    }
};
