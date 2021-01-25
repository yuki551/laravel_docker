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
            $table->integer('user')->nullable();
            $table->integer('team')->nullable();
            $table->string('summary_am')->nullable();
            $table->integer('client_am')->nullable();
            $table->text('contents_am')->nullable();
            $table->string('summary_pm')->nullable();
            $table->integer('client_pm')->nullable();
            $table->text('contents_pm')->nullable();
            $table->text('comment')->nullable();
            $table->integer('status')->nullable();
            $table->timestamp('status_updated_at')->nullable();
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->timestamp('updated_at')->useCurrent()->nullable();
            $table->integer('created_user_id')->nullable();
            $table->integer('updated_user_id')->nullable();
            $table->boolean('deleted_flag')->nullable();

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
