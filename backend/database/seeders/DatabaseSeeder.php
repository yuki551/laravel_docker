<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\TeamsTableSeeder;
use Database\Seeders\RolesTableSeeder;
use Database\Seeders\AdminCreateSeeder;
use Database\Seeders\TestUserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            TeamsTableSeeder::class,
            RolesTableSeeder::class,
            AdminCreateSeeder::class,
            TestUserSeeder::class,
        ]);
    }
}
