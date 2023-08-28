<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 25) as $index) {
            $category = $faker->biasedNumberBetween(1,4);
            $title = $faker->sentence;
            $newsText = $faker->paragraph(5);
            $newsPreview = $faker->sentence(10);
            $publicationDate = $faker->dateTimeBetween('-1 month', now('Asia/Almaty'));
            $views = $faker->numberBetween(0, 100);

            DB::table('news')->insert([
                'category_id' => $category,
                'title' => $title,
                'news_text' => $newsText,
                'news_preview' => $newsPreview,
                'publication_date' => $publicationDate,
                'views' => $views,
            ]);
        }
    }
}
