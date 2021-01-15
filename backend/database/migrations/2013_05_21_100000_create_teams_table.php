<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();

            $table->string('name');
            $table->timestamps();
            $table->integer('created_user_id')->nullable();
            $table->integer('updated_user_id')->nullable();
            $table->boolean('deleted_flag')->nullable();

            $table->foreignId('user_id')->index();
            $table->boolean('personal_team')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('teams');
    }
}
