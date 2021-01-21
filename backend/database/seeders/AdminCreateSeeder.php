<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminCreateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                'id' => 1,
                'name' => 'admin',
                'email' => 'admin@example.com',
                'password' => '$2y$10$u92P1qTDvaXBKyFj5ZnqGe75Z22opIBn0arYlnRWvFIK9lW6hHiQu',
                'current_team_id' => 1,
                'role_id' => 1,
            ]
        );
    }
}
