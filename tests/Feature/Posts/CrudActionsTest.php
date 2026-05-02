<?php

namespace Tests\Feature\Posts;

use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class CrudActionsTest extends TestCase
{
    public function test_can_view_all_posts_in_list()
    {
        $users = [
            User::factory()->admin()->create(),
            User::factory()->editor()->create(),
        ];

        $posts = Post::factory(10)->create();

        foreach ($users as $user) {
            $this->actingAs($user)
                ->get(route('posts.index'))
                ->assertStatus(200)
                ->assertSee($posts->pluck('title')->toArray());
        }
    }

    public function test_can_edit_all_posts()
    {
        $users = [
            User::factory()->admin()->create(),
            User::factory()->editor()->create(),
        ];

        $posts = Post::factory(10)->create();
        $editLinks = $posts->map(fn(Post $post) => route('posts.edit', $post->id));

        foreach ($users as $user) {
            $this->actingAs($user)
                ->get(route('posts.index'))
                ->assertStatus(200)
                ->assertSee($editLinks->toArray());

            foreach ($editLinks as $link) {
                $this->actingAs($user)
                    ->get($link)
                    ->assertStatus(200);
            }
        }
    }

    public function test_can_create_posts_with_publishing()
    {
        $users = [
            User::factory()->admin()->create(),
            User::factory()->editor()->create(),
        ];

        foreach ($users as $user) {
            $this->actingAs($user)
                ->get(route('posts.create'))
                ->assertSee(__('Published'))
                ->assertSee(__('Create Post'));

            $this->actingAs($user)
                ->post(route('posts.store'), [
                    'title' => 'Test Post',
                    'content' => 'Test Content',
                    'is_published' => '1',
                    'meta_title' => 'Test Meta Title',
                    'meta_description' => 'Test Meta Description',
                ])
                ->assertStatus(302);
        }
    }

    public function test_can_delete_all_posts()
    {
        $users = [
            User::factory()->admin()->create(),
            User::factory()->editor()->create(),
        ];

        foreach ($users as $user) {
            $posts = Post::factory(10)->create();
            foreach ($posts as $post) {
                $this->actingAs($user)
                    ->delete(route('posts.destroy', $post->id))
                    ->assertStatus(302);
            }
        }
    }

    public function test_can_view_only_his_posts_in_list()
    {
        $users = [
            User::factory()->author()->create(),
            User::factory()->contributor()->create(),
        ];

        foreach ($users as $user) {
            $posts = Post::factory(10)->create(['user_id' => $user->id]);
            $otherPosts = Post::factory(10)->create();

            $this->actingAs($user)
                ->get(route('posts.index'))
                ->assertStatus(200)
                ->assertSee($posts->pluck('title')->toArray())
                ->assertDontSee($otherPosts->pluck('title')->toArray());
        }
    }

    public function test_author_can_create_and_publish_his_own_posts()
    {
        $user = User::factory()->author()->create();

        $this->actingAs($user)
            ->get(route('posts.create'))
            ->assertSee(__('Published'))
            ->assertSee(__('Create Post'));

        $this->actingAs($user)
            ->post(route('posts.store'), [
                'title' => 'Test Post',
                'content' => 'Test Content',
                'is_published' => '1',
                'meta_title' => 'Test Meta Title',
                'meta_description' => 'Test Meta Description',
            ])
            ->assertStatus(302);

        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'content' => 'Test Content',
            'is_published' => true,
            'meta_title' => 'Test Meta Title',
            'meta_description' => 'Test Meta Description',
        ]);
    }

    public function test_author_can_edit_his_own_posts()
    {
        $users = [
            User::factory()->author()->create(),
            User::factory()->contributor()->create(),
        ];

        foreach ($users as $user) {
            $post = Post::factory()->create(['user_id' => $user->id]);

            $this->actingAs($user)
                ->get(route('posts.edit', $post->id))
                ->assertStatus(200)
                ->assertSee(__('Edit Post'))
                ->assertSee(__('Update Post'));

            $this->actingAs($user)
                ->put(route('posts.update', $post->id), [
                    'title' => 'Test Post',
                    'content' => 'Test Content',
                ])
                ->assertStatus(302);

            $this->assertDatabaseHas('posts', [
                'title' => 'Test Post',
                'content' => 'Test Content',
            ]);
        }
    }

    public function test_author_can_delete_his_own_posts()
    {
        $users = [
            User::factory()->author()->create(),
            User::factory()->contributor()->create(),
        ];

        foreach ($users as $user) {
            $post = Post::factory()->create(['user_id' => $user->id]);

            $this->actingAs($user)
                ->delete(route('posts.destroy', $post->id))
                ->assertStatus(302);

            $this->assertDatabaseMissing('posts', [
                'id' => $post->id,
            ]);
        }
    }

    public function test_contributor_cannot_publish_posts()
    {
        $user = User::factory()->contributor()->create();

        $this->actingAs($user)
            ->get(route('posts.create'))
            ->assertDontSee(__('Published'))
            ->assertSee(__('Create Post'));

        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->post(route('posts.store'), [
                'title' => 'Test Post',
                'content' => 'Test Content',
                'is_published' => '1',
            ])
            ->assertStatus(302);

        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'content' => 'Test Content',
            'is_published' => false,
        ]);

        $this->actingAs($user)
            ->get(route('posts.edit', $post->id))
            ->assertDontSee(__('Published'))
            ->assertSee(__('Edit Post'));

        $this->actingAs($user)
            ->put(route('posts.update', $post->id), [
                'title' => 'Test Post',
                'content' => 'Test Content',
                'is_published' => '1',
            ])
            ->assertStatus(302);

        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'content' => 'Test Content',
            'is_published' => false,
        ]);
    }

    public function test_cannot_edit_other_users_posts()
    {
        $users = [
            User::factory()->author()->create(),
            User::factory()->contributor()->create(),
        ];

        $post = Post::factory()->create();

        foreach ($users as $user) {
            $this->actingAs($user)
                ->get(route('posts.edit', $post->id))
                ->assertStatus(403);
        }
    }

    public function test_cannot_delete_other_users_posts()
    {
        $users = [
            User::factory()->author()->create(),
            User::factory()->contributor()->create(),
        ];

        $post = Post::factory()->create();

        foreach ($users as $user) {
            $this->actingAs($user)
                ->delete(route('posts.destroy', $post->id))
                ->assertStatus(403);
        }
    }
}
