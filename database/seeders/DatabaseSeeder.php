<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserType;
use App\Models\Category;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'type' => UserType::ADMIN,
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        Category::factory()->create([
            'name' => 'Search engines',
            'description' => 'A collection of search engines',
        ]);

        Category::factory()->create([
            'name' => 'Social media platforms',
            'description' => 'A collection of social media platforms',
        ]);
    }
}
