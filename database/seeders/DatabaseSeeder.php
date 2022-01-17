<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $User = \App\Models\User::factory(10)->create();
        \App\Models\Post::factory(5)->create();
    }
}
