<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\TeamsTableSeeder;
use Database\Seeders\AdminCreateSeeder;

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
            AdminCreateSeeder::class,
        ]);
    }
}
