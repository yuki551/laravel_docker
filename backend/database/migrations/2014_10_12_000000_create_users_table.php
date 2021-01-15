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
            $table->char('id', 4)->primary('id')->autoIncrement()->default(0000);
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->text('profile_photo_path')->nullable();

            $table->char('current_team_id', 2)->nullable();
            $table->char('role_id', 3)->nullable();

            $table->timestamps();

            $table->char('created_user_id', 4)->default(0000);
            $table->char('updated_user_id', 4)->default(0000);
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
