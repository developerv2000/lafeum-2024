<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AuthorGroupSeeder::class,
            AuthorSeeder::class,
            TermTypeSeeder::class,
            CountrySeeder::class,
            GenderSeeder::class,
        ]);

        $user = User::create([
            'name' => 'Administrator',
            'email' => 'admin@mail.com',
            'password' => bcrypt('12345'),
            'email_verified_at' => now(),
        ]);

        $user->roles()->attach([1]);

        $settings = [
            'preferred_theme' => 'light',
            'collapsed_dashboard_leftbar' => false,
        ];

        $user->update([
            'settings' => $settings,
        ]);
    }
}
