<?php

namespace Database\Seeders;

use App\Models\Tour;
use App\Models\User;
use Database\Factories\TourFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Tour::factory()->count(5)->create();
        User::truncate();
        $admin = User::updateOrCreate([
            'name' => 'Admin',
            'email' => 'admin@solutest.com',
            'role' => 'admin',
            'password' => 'password'
        ]);

        $user = User::updateOrCreate([
            'name' => 'Mugambi',
            'email' => 'test@solutest.com',
            'role' => 'user',
            'password' => 'password'
        ]);
    }
}
