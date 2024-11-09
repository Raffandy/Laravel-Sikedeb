<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat admin
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        // Membuat user 1
        User::factory()->create([
            'name' => 'user 1',
            'email' => 'user1@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'user',
        ]);

        // Membuat user 2
        User::factory()->create([
            'name' => 'user 2',
            'email' => 'user2@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'user',
        ]);
    }
}
