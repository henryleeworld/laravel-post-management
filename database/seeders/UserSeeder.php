<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        User::factory()
            ->admin()
            ->create([
                'name' => __('Administrator'),
                'email' => 'admin@admin.com',
            ]);

        User::factory()
            ->editor()
            ->create([
                'name' => __('Editor'),
                'email' => 'editor@admin.com',
            ]);

        User::factory()
            ->contributor()
            ->create([
                'name' => __('Contributor'),
                'email' => 'contributor@admin.com',
            ]);
    }
}
