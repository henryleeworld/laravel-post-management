<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->hasPermissionTo('posts-view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('posts-create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        if ($post->user_id !== $user->id) {
            return $user->hasPermissionTo('posts-edit-others');
        }

        return $user->hasPermissionTo('posts-update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        if ($post->user_id !== $user->id) {
            return $user->hasPermissionTo('posts-edit-others');
        }

        return $user->hasPermissionTo('posts-delete');
    }

    public function publish(User $user): bool
    {
        return $user->hasPermissionTo('posts-publish');
    }

    public function editOthers(User $user): bool
    {
        return $user->hasPermissionTo('posts-edit-others');
    }
}
