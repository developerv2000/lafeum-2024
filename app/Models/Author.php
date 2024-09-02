<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasFactory;
    use SoftDeletes;

    const PHOTO_PATH = 'img/authors';

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
    | Additional attributes
    |--------------------------------------------------------------------------
    */

    public function getPhotoAssetPathAttribute(): string
    {
        return asset(self::PHOTO_PATH . '/' . $this->photo);
    }

    public function getPhotoFilePathAttribute()
    {
        return public_path(self::PHOTO_PATH . '/' . $this->photo);
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
