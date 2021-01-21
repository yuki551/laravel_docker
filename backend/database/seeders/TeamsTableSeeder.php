<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teams')->insert([
            [
                'name' => '管理',
                'user_id' => 1,
                'personal_team' => 0,
            ],
            [
                'name' => '総務',
                'user_id' => 1,
                'personal_team' => 0,
            ],
            [
                'name' => '営業第一',
                'user_id' => 1,
                'personal_team' => 0,
            ],
            [
                'name' => '営業第二',
                'user_id' => 1,
                'personal_team' => 0,
            ],
            [
                'name' => '工務',
                'user_id' => 1,
                'personal_team' => 0,
            ]
        ]);
    }
}
