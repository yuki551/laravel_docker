<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name' => '管理者',
                'role_id' => 1,
            ],
            [
                'name' => '社長',
                'role_id' => 3,
            ],
            [
                'name' => '部長',
                'role_id' => 5,
            ],
            [
                'name' => '一般社員',
                'role_id' => 10,
            ]
        ]);
    }
}
