<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\User;
use Database\Factories\CharacterFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CharacterSeeder::class);
    }
}
