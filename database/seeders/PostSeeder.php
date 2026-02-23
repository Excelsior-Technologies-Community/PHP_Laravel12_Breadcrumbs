<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Category;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $tech = Category::where('name', 'Technology')->first();
        $life = Category::where('name', 'Lifestyle')->first();

        Post::create(['title' => 'Laravel 12 Breadcrumbs', 'content' => 'This is a Laravel 12 tutorial for breadcrumbs.', 'category_id' => $tech->id]);
        Post::create(['title' => 'Healthy Living', 'content' => 'Tips for a healthy lifestyle.', 'category_id' => $life->id]);
    }
}