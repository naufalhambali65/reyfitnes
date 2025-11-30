<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'REY FITNES ADMIN',
            'email' => 'reyfitnes.cs@gmail.com',
            'role' => 'admin',
            'password' => bcrypt('reyfitnes011225'),
        ]);
        User::factory()->create([
            'name' => 'naufal',
            'email' => 'naufalhambali65@gmail.com',
            'role' => 'super_admin',
            'password' => bcrypt('password'),
        ]);
    }
}
