<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'teknoloji',
            'status' => 1,
        ]);


        Category::create([
            'name' => 'sağlık',
            'status' => 1,
        ]);

        Category::create([
            'name' => 'spor',
            'status' => 1,
        ]);
    }
}
