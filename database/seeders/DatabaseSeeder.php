<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use Exception;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @throws Exception
     */
    public function run(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $post = Post::factory()
                ->create();
            $count = 5;
            for ($j = 0; $j < $count; $j++) {
                Comment::factory()->create(['post_id' => $post->id]);
            }
        }
    }
}
