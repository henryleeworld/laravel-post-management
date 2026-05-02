<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CrudActionsTest extends TestCase
{
    public function test_only_admins_can_access_create_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('users.create'))
            ->assertStatus(403);
    }

    public function test_non_admins_cannot_create_users()
    {
        $users = [
            User::factory()->editor()->create(),
            User::factory()->author()->create(),
            User::factory()->contributor()->create(),
        ];

        foreach ($users as $user) {
            $this->actingAs($user)
                ->get(route('users.create'))
                ->assertStatus(403);
        }
    }

    public function test_admin_can_create_users()
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('users.store'), [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => 'password',
                'role' => 'Editor',
            ])
            ->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->assertDatabaseHas('model_has_roles', [
            'role_id' => Role::where('name', 'Editor')->first()->id,
        ]);
    }

    public function test_admin_can_edit_users()
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->create();

        $this->actingAs($admin)
            ->put(route('users.update', $user->id), [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => 'password512',
                'role' => 'Editor',
            ])
            ->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->assertDatabaseHas('model_has_roles', [
            'role_id' => Role::where('name', 'Editor')->first()->id,
        ]);

        $user = $user->fresh();
        $this->assertTrue(Hash::check('password512', $user->password));
    }

    public function test_admin_can_update_users_without_password()
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->create();

        $this->actingAs($admin)
            ->put(route('users.update', $user->id), [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'role' => 'Editor',
            ])
            ->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->assertDatabaseHas('model_has_roles', [
            'role_id' => Role::where('name', 'Editor')->first()->id,
        ]);

        $user = $user->fresh();
        $this->assertTrue(Hash::check('password', $user->password));
    }

    public function test_admin_can_view_user_list()
    {
        $admin = User::factory()->admin()->create();
        $users = User::factory()->count(10)->create();

        $this->actingAs($admin)
            ->get(route('users.index'))
            ->assertStatus(200)
            ->assertSeeText($users->pluck('name')->toArray());
    }

    public function test_admin_can_delete_users()
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->create();

        $this->actingAs($admin)
            ->delete(route('users.destroy', $user->id))
            ->assertRedirect(route('users.index'));
    }

    public function test_other_roles_cannot_delete_users()
    {
        $users = [
            User::factory()->editor()->create(),
            User::factory()->author()->create(),
            User::factory()->contributor()->create(),
        ];

        foreach ($users as $user) {
            $this->actingAs($user)
                ->delete(route('users.destroy', $user->id))
                ->assertStatus(403);
        }
    }

    public function test_other_roles_cannot_edit_users()
    {
        $users = [
            User::factory()->editor()->create(),
            User::factory()->author()->create(),
            User::factory()->contributor()->create(),
        ];

        foreach ($users as $user) {
            $this->actingAs($user)
                ->get(route('users.edit', $user->id))
                ->assertStatus(403);

            $this->put(route('users.update', $user->id), [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => 'password512',
                'role' => 'Editor',
            ])->assertStatus(403);
        }
    }
}
