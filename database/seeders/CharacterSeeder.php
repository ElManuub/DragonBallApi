<?php

namespace Database\Seeders;

use App\Models\Character;
use Database\Factories\CharacterFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CharacterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Character::factory()->count(10)->create();
 }
}
