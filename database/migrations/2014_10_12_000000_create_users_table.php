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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('password', 100);
            $table->string('username')->nullable();
            $table->string('email', 200)->unique();
            $table->string('job_title')->nullable();
            $table->string('department')->nullable();
            $table->bigInteger('manager_id')->unsigned()->nullable();
            $table->string('phone', 25);
            $table->string('address1', 500)->nullable();
            $table->string('address2', 500)->nullable();
            $table->enum('status', ['active', 'inactive']);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
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
        Schema::dropIfExists('users');
    }
};
