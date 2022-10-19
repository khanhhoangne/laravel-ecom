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
        Schema::create('acl_routes', function (Blueprint $table) {
            $table->id();
            $table->string('route', 200);
            $table->bigInteger('command_id')->unsigned();
            $table->bigInteger('permission_id')->unsigned();
            $table->foreign('command_id')->references('id')->on('acl_commands')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('acl_permissions')->onDelete('cascade');
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
        Schema::dropIfExists('acl_routes');
    }
};
