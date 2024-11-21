<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@mail.com',
            ],

            [
                'name' => 'Administrator2',
                'email' => 'admin2@mail.com',
            ],

            [
                'name' => 'Administrator3',
                'email' => 'admin3@mail.com',
            ]
        ];

        foreach ($users as $user) {
            $u = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => bcrypt('12345'),
                'email_verified_at' => now(),
                'settings' => [
                    'preferred_theme' => 'light',
                    'collapsed_dashboard_leftbar' => false,
                ],
            ]);

            $u->roles()->attach([1]);
        }
    }
}
