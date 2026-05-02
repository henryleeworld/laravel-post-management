<?php

namespace Tests\Feature\PageSettings;

use App\Models\User;
use App\Models\Setting;
use Tests\TestCase;

class PageSettingsTest extends TestCase
{
    public function test_can_open_page_settings_page_but_forbidden_for_normal_user()
    {
        $this->actingAs(User::factory()->create())
            ->get(route('page-settings.index'))
            ->assertStatus(403);
    }

    public function test_admin_can_open_page_settings_page()
    {
        $this->actingAs(User::factory()->admin()->create())
            ->get(route('page-settings.index'))
            ->assertStatus(200);
    }

    public function test_users_without_permission_cannot_open_page_settings_page()
    {
        $users = [
            User::factory()->create(),
            User::factory()->editor()->create(),
            User::factory()->author()->create(),
            User::factory()->contributor()->create(),
        ];

        foreach ($users as $user) {
            $this->actingAs($user)
                ->get(route('page-settings.index'))
                ->assertStatus(403);
        }
    }

    public function test_admin_can_update_page_settings()
    {
        Setting::create([
            'title' => 'Laravel',
            'maintenance_mode' => '0',
        ]);

        $this->actingAs(User::factory()->admin()->create())
            ->post(route('page-settings.update'), [
                'title' => 'Test Page',
                'maintenance_mode' => '1',
            ])
            ->assertStatus(302);

        $this->assertDatabaseHas('settings', [
            'title' => 'Test Page',
            'maintenance_mode' => '1',
        ]);
    }

    public function test_users_without_permission_cannot_update_page_settings()
    {
        Setting::create([
            'title' => 'Laravel',
            'maintenance_mode' => '0',
        ]);

        $users = [
            User::factory()->create(),
            User::factory()->editor()->create(),
            User::factory()->author()->create(),
            User::factory()->contributor()->create(),
        ];

        foreach ($users as $user) {
            $this->actingAs($user)
                ->post(route('page-settings.update'), [
                    'title' => 'Test Page',
                    'maintenance_mode' => '1',
                ])
                ->assertStatus(403);
        }
    }
}
