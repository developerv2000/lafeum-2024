<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function group()
    {
        return $this->belongsTo(AuthorGroup::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Queries
    |--------------------------------------------------------------------------
    */

    public function scopeOnlyPeople($query)
    {
        return $query->where('author_group_id', AuthorGroup::findByName(AuthorGroup::PEOPLE_NAME)->id);
    }

    public function scopeOnlyMovies($query)
    {
        return $query->where('author_group_id', AuthorGroup::findByName(AuthorGroup::MOVIES_NAME)->id);
    }

    public function scopeOnlyProverbs($query)
    {
        return $query->where('author_group_id', AuthorGroup::findByName(AuthorGroup::PROVERBS_NAME)->id);
    }
}
