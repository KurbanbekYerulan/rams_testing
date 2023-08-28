<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['category' => 'Technology', 'description' => 'Technology'],
            ['category' => 'Sports', 'description' => 'Sports'],
            ['category' => 'Business', 'description' => 'Business'],
            ['category' => 'Entertainment', 'description' => 'Entertainment'],
        ];

        DB::table('news_categories')->insert($categories);
    }
}
