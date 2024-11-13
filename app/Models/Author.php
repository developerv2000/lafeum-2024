<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    const PHOTO_PATH = 'img/authors';
    const PAGINATION_LIMIT_FOR_FRONT = 20;

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function group()
    {
        return $this->belongsTo(AuthorGroup::class);
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class);
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

    /**
     * Get finalized records for the front-end based on the specified query and action.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query The query builder instance.
     * @param string $finaly The action to perform: 'paginate', 'get', or 'query'.
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder The modified query or the retrieved results.
     */
    public static function getFinalizedRecordsForFront($query = null, $finaly = 'paginate')
    {
        $query = $query ?: self::query();

        $query->orderBy('name', 'asc');

        // Return result based on the finaly option
        switch ($finaly) {
            case 'paginate':
                return $query->paginate(self::PAGINATION_LIMIT_FOR_FRONT);

            case 'get':
                return $query->get();

            case 'query':
            default:
                return $query;
        }
    }

    public static function getAllMinified()
    {
        return self::select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Miscellaneous
    |--------------------------------------------------------------------------
    */

    /**
     * Used in authors.index page
     */
    public static function prependNonPersonGroupLinks($records)
    {
        $records->prepend(new self([
            'name' => AuthorGroup::PROVERBS_NAME,
            'slug' => AuthorGroup::PROVERBS_SLUG
        ]));

        $records->prepend(new self([
            'name' => AuthorGroup::MOVIES_NAME,
            'slug' => AuthorGroup::MOVIES_SLUG,
        ]));
    }

    /**
     * Used in authors.show page
     */
    public static function getAuthorBySlug($slug): \App\Models\Author|\App\Models\AuthorGroup
    {
        switch ($slug) {
                // Case MOVIES
            case AuthorGroup::MOVIES_SLUG:
                $author = AuthorGroup::findByName(AuthorGroup::MOVIES_NAME);
                break;

                // CASE PROVERBS
            case AuthorGroup::PROVERBS_SLUG:
                $author = AuthorGroup::findByName(AuthorGroup::PROVERBS_NAME);
                break;

                // CASE PEOPLE
            default:
                $author = Author::where('slug', $slug)->firstOrFail();
                break;
        }

        return $author;
    }
}
