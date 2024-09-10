<?php

namespace App\Models;

use App\Support\Traits\Favoriteable;
use App\Support\Traits\Likeable;
use App\Support\Traits\Publishable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Term extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Publishable;
    use Likeable;
    use Favoriteable;

    const PAGINATION_LIMIT_FOR_FRONT = 20;

    protected $with = [
        'type',
        'categories',
        'likes',
        'favorites',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function type()
    {
        return $this->belongsTo(TermType::class, 'term_type_id');
    }

    public function knowledges()
    {
        return $this->belongsToMany(Knowledge::class);
    }

    public function categories()
    {
        return $this->belongsToMany(TermCategory::class, 'category_term', 'term_id', 'category_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Additional attributes
    |--------------------------------------------------------------------------
    */

    public function getMinifiedSubtermsAttribute()
    {
        // get all links
        preg_match_all('/https?:\/\/(www\.)?lafeum\.ru[^\s]*/', $this->body, $links);

        // extract all ids from links path https://domain.com/term/{id}
        $ids = array();

        foreach ($links[0] as $link) {
            $parsed = parse_url($link);
            $ids[] = substr($parsed['path'], 6);
        }

        $subterms = self::whereIn('id', $ids)->select('id', 'body')->withOnly([])->get();

        return $subterms;
    }

    /*
    |--------------------------------------------------------------------------
    | Queries
    |--------------------------------------------------------------------------
    */

    public function scopeOnlyVocabulary($query)
    {
        return $query->where('show_in_vocabulary', true)
            ->where('name', '!=', '');
    }

    /**
     * Get finalized records for the front-end based on the specified query and action.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query The query builder instance.
     * @param string $finaly The action to perform: 'paginate', 'get', or 'query'.
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder The modified query or the retrieved results.
     */
    public static function getFinalizedRecordsForFront($query, $finaly = 'paginate')
    {
        // Apply common query modifications
        $query->onlyPublished()
            ->orderBy('publish_at', 'desc');

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

    /**
     * Get finalized vocabulary records for the front-end based on the specified query and action.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query The query builder instance.
     * @param string $finaly The action to perform: 'paginate', 'get', or 'query'.
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder The modified query or the retrieved results.
     */
    public static function getFinalizedVocabularyRecordsForFront($query = null, $finaly = 'get')
    {
        $query = $query ?: self::query();

        // Apply common query modifications
        $query->onlyVocabulary()
            ->onlyPublished()
            ->select('id', 'name')
            ->withOnly([])
            ->orderBy('name', 'asc');

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

    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::forceDeleting(function ($item) {
            $item->knowledges()->detach();
            $item->categories()->detach();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Miscellaneous
    |--------------------------------------------------------------------------
    */

    /**
     * Generate an associative array of subterms from the given terms collection.
     * Used in term cards
     *
     * @return array
     */
    public static function generateSubtermsArray($terms): array
    {
        // Extract subterms collections from each term
        $subtermsCollection = $terms->pluck('minified_subterms');

        // Flatten subterms collections into one collection
        $combinedSubtermsCollection = $subtermsCollection->flatten();

        // Filter out duplicate subterms by unique 'id'
        $uniqueCombinedSubtermsCollection = $combinedSubtermsCollection->unique('id');

        // Initialize an empty array to store subterms
        $subtermsArray = [];

        // Map each unique subterm's id to its body
        $uniqueCombinedSubtermsCollection->each(function ($subterm) use (&$subtermsArray) {
            $subtermsArray[$subterm->id] = $subterm->body;
        });

        // Return the associative array of subterms
        return $subtermsArray;
    }
}
