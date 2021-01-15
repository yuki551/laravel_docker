<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // php artisan migrate:fresh
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('user', 4);
            $table->char('team', 2);
            $table->string('summary_am');
            $table->char('client_am', 4);
            $table->text('contents_am');
            $table->string('summary_pm');
            $table->char('client_pm', 4);
            $table->text('contents_pm');
            $table->integer('status');
            $table->timestamp('status_updated_at');
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->timestamp('updated_at')->useCurrent()->nullable();
            $table->timestamp('created_user_id')->useCurrent()->nullable();
            $table->timestamp('updated_user_id')->useCurrent()->nullable();
            $table->boolean('deleted_flag');

            $table->foreign('user')->references('id')->on('users');
            $table->foreign('team')->references('id')->on('teams');

            $table->foreign('client_am')->references('id')->on('clients');
            $table->foreign('client_pm')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
