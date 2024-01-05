<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = \App\Models\User::factory(3)->create();

        foreach ($users as $user) {
            $posts = \App\Models\Post::factory(3)->create([
                'user_id' => $user->id,
            ]);

            foreach ($posts as $post) {
                \App\Models\Comment::factory(3)->create([
                    'post_id' => $post->id,
                    'user_id' => $users->random(1)->first()->id,
                ]);
            }
        }
    }
}
