<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 2,
                'name' => '総務くん',
                'email' => 'test@example.com',
                'password' => '$2y$10$u92P1qTDvaXBKyFj5ZnqGe75Z22opIBn0arYlnRWvFIK9lW6hHiQu',
                'current_team_id' => 2,
                'role_id' => 1,
            ],
            [
                'id' => 3,
                'name' => '営業第一くん',
                'email' => 'test2@example.com',
                'password' => '$2y$10$u92P1qTDvaXBKyFj5ZnqGe75Z22opIBn0arYlnRWvFIK9lW6hHiQu',
                'current_team_id' => 3,
                'role_id' => 1,
            ],
            [

                'id' => 4,
                'name' => '営業第二くん',
                'email' => 'test3@example.com',
                'password' => '$2y$10$u92P1qTDvaXBKyFj5ZnqGe75Z22opIBn0arYlnRWvFIK9lW6hHiQu',
                'current_team_id' => 4,
                'role_id' => 1,
            ],

            [
                'id' => 5,
                'name' => '工務くん',
                'email' => 'test4@example.com',
                'password' => '$2y$10$u92P1qTDvaXBKyFj5ZnqGe75Z22opIBn0arYlnRWvFIK9lW6hHiQu',
                'current_team_id' => 5,
                'role_id' => 1,
            ],
            [
                'id' => 6,
                'name' => '社長さん',
                'email' => 'test5@example.com',
                'password' => '$2y$10$u92P1qTDvaXBKyFj5ZnqGe75Z22opIBn0arYlnRWvFIK9lW6hHiQu',
                'current_team_id' => 1,
                'role_id' => 10,
            ],
            [
                'id' => 7,
                'name' => '営業第一部長',
                'email' => 'test6@example.com',
                'password' => '$2y$10$u92P1qTDvaXBKyFj5ZnqGe75Z22opIBn0arYlnRWvFIK9lW6hHiQu',
                'current_team_id' => 3,
                'role_id' => 5,
            ],
        ]);
    }
}
