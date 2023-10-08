<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $uSeed = new UsersTableSeeder();
        $uSeed->run();

        $nSeed = new NewsTableSeeder();
        $nSeed->run();
    }
}
