<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    public function run(): void
    {
        $tags = Tag::all();
        if ($tags->isEmpty()) {
            $tags = Tag::factory(5)->create();
        }
        Article::factory(30)->create()->each(function ($article) use ($tags) {
            $article->tags()->attach(
                $tags->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
        
    }
}
