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
        Schema::table('acl_role_has_permissions', function (Blueprint $table) {
            $table->bigInteger('command_id')->unsigned();
            $table->foreign('command_id')->references('id')->on('acl_commands')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('acl_role_has_permissions', function (Blueprint $table) {
            $table->dropForeign(['command_id']);
            $table->dropColumn('command_id');
        });
    }
};
