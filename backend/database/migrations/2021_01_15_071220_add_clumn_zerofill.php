<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddClumnZerofill extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // zerofill追加用
        // Schema::table('posts', function (Blueprint $table) {
        //     $posts = 'ALTER TABLE posts CHANGE id id INT(4) ZEROFILL AUTO_INCREMENT';
        //     // $users = 'ALTER TABLE users CHANGE id id INT(4) ZEROFILL AUTO_INCREMENT';
        //     $teams = 'ALTER TABLE teams CHANGE id id INT(2) ZEROFILL AUTO_INCREMENT';
        //     $clients = 'ALTER TABLE clients CHANGE id id INT(4) ZEROFILL AUTO_INCREMENT';
        //     $roles = 'ALTER TABLE roles CHANGE id id INT(3) ZEROFILL AUTO_INCREMENT';
        //     DB::statement($posts);
        //     // DB::statement($users);
        //     DB::statement($teams);
        //     DB::statement($clients);
        //     DB::statement($roles);
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
