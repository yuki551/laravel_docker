<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->text('profile_photo_path')->nullable();

            $table->integer('current_team_id')->nullable();
            $table->integer('role_id')->nullable();

            $table->timestamps();

            $table->integer('created_user_id')->nullable();
            $table->integer('updated_user_id')->nullable();
            $table->boolean('deleted_flag')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();

            $table->foreign('current_team_id')->references('id')->on('teams');
            $table->foreign('role_id')->references('id')->on('roles');
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
}
