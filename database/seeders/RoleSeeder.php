<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['name' => Role::ADMINISTRATOR_NAME],
            ['name' => Role::AUTHOR_NAME],
            ['name' => Role::USER_NAME],
            ['name' => Role::INACTIVE_NAME],
        ]);
    }
}
