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
            $table->char('id', 2)->primary('id')->autoIncrement();

            $table->string('name');
            $table->timestamps();
            $table->char('created_user_id', 4);
            $table->char('updated_user_id', 4);
            $table->boolean('deleted_flag');

            $table->foreignId('user_id')->index();
            $table->boolean('personal_team');
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
