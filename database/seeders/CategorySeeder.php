<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()->create([
            'name' => 'Web Programming',
            'slug' => 'web-programming',
            'color' => 'bg-red-100'
        ]);
        Category::create([
            'name' => 'Web Design',
            'slug' => 'web-design',
            'color' => 'bg-green-100'
        ]);
        Category::create([
            'name' => 'Articial Intelligence',
            'slug' => 'articial-intelligence',
            'color' => 'bg-blue-100'
        ]);
    }
}
