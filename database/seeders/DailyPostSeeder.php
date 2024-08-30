<?php

namespace Database\Seeders;

use App\Models\DailyPost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DailyPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DailyPost::create([
            'date' => now(),
            'quote_id' => 1,
            'term_id' => 1,
            'video_id' => 1,
            'photo_id' => 1,
        ]);
    }
}
