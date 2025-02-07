<?php

// ===== Helper function to copy data from all database =====

// 2 duplicate authors
Tempor::where('name', 'Юрий Линник')->get()->dd();
Tempor::where('name', 'Владимир Семёнович Барулин')->get()->dd();
Tempor::whereIn('id', [994, 995])->delete();

// Author photo path
Author::each(function (Author $record) {
    $record->timestamps = false;
    $record->photo = $record->photo ? substr($record->photo, 13) : 'error.png';
    $record->saveQuietly();
});

// Copying category attaches
Tempor::where('categoriable_type', 'App\Quote')->get()->each(function ($tempor) {
    DB::table('category_quote')->insert([
        'quote_id' => $tempor->categoriable_id,
        'category_id' => $tempor->category_id,
    ]);
});

Tempor::where('categoriable_type', 'App\Video')->get()->each(function ($tempor) {
    DB::table('category_video')->insert([
        'video_id' => $tempor->categoriable_id,
        'category_id' => $tempor->category_id,
    ]);
});

Tempor::where('categoriable_type', 'App\Term')->get()->each(function ($tempor) {
    DB::table('category_term')->insert([
        'term_id' => $tempor->categoriable_id,
        'category_id' => $tempor->category_id,
    ]);
});

// Copying categories
Tempor::where('type', 'App\Quote')->get()->each(function ($record) {
    DB::table('quote_categories')->insert([
        'id' => $record->id,
        'name' => $record->name,
        'description' => $record->description,
        'slug' => $record->slug,
        'parent_id' => $record->parent_id,
        '_lft' => 0,
        '_rgt' => 0,
    ]);
});

Tempor::where('type', 'App\Term')->get()->each(function ($record) {
    DB::table('term_categories')->insert([
        'id' => $record->id,
        'name' => $record->name,
        'description' => $record->description,
        'slug' => $record->slug,
        'parent_id' => $record->parent_id,
        '_lft' => 0,
        '_rgt' => 0,
    ]);
});

Tempor::where('type', 'App\Video')->get()->each(function ($record) {
    DB::table('video_categories')->insert([
        'id' => $record->id,
        'name' => $record->name,
        'description' => $record->description,
        'slug' => $record->slug,
        'parent_id' => $record->parent_id,
        '_lft' => 0,
        '_rgt' => 0,
    ]);
});

// Duplicate channels
Tempor::where('name', 'Marshall EN')->get()->dd();
Tempor::whereIn('id', [299])->delete();

// Photo
Photo::each(function ($record) {
    $record->timestamps = false;
    $record->filename = $record->filename ? substr($record->filename, 12) : 'error.png';
    $record->saveQuietly();
});
