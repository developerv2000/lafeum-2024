<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genders = [
            Gender::MALE_NAME,
            Gender::FEMALE_NAME
        ];

        foreach ($genders as $gender) {
            Gender::create([
                'name' => $gender
            ]);
        }
    }
}
