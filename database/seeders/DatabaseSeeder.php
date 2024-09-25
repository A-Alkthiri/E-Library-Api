<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Ad;
use App\Models\Category;
use App\Models\Content;
use App\Models\ContentType;
use App\Models\Media;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create categories and content types first
        Category::factory(5)->create(); // 5 random categories
        ContentType::factory(3)->create(); // 3 content types (Book, Video, Magazine)

        // Create user
        DB::table('users')->insert([
            'name' => "E-library",//fake()->name(),
            'email' => "library@gmail.com",//fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'role' => "admin",
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10)
        ]);
        // Create contents
        Content::factory(20)->create(); // 20 random contents

        // Create media for contents
        Media::factory(20)->create(); // 20 random media

        // Create ads
        Ad::factory(5)->create(); // 5 random ads
    }
}
