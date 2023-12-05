<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Review;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Book::factory(33)->create()->each(function($book){
            $numberReviews=random_int(5,15);

            Review::factory()->count($numberReviews)->good()->for($book)->create();
        });

        Book::factory(33)->create()->each(function($book){
            $numberReviews=random_int(5,15);

            Review::factory()->count($numberReviews)->avarage()->for($book)->create();
        });

        Book::factory(34)->create()->each(function($book){
            $numberReviews=random_int(5,15);

            Review::factory()->count($numberReviews)->bad()->for($book)->create();
        });
    }
}
