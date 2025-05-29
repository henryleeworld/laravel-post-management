<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        $author = User::factory()
            ->author()
            ->create([
                'name' => __('Author'),
                'email' => 'author@admin.com',
            ]);

        Post::factory()
            ->for($author)
            ->count(10)
            ->create();
    }
}
