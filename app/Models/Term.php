<?php

namespace App\Models;

use App\Support\Helpers\QueryFilterHelper;
use App\Support\Traits\Model\AddsQueryParamsToRequest;
use App\Support\Traits\Model\Favoriteable;
use App\Support\Traits\Model\FinalizesQueryForRequest;
use App\Support\Traits\Model\Likeable;
use App\Support\Traits\Model\Publishable;
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
    use AddsQueryParamsToRequest;
    use FinalizesQueryForRequest;

    const DEFAULT_FRONT_ORDER_BY = 'publish_at';
    const DEFAULT_FRONT_ORDER_TYPE = 'desc';
    const DEFAULT_FRONT_PAGINATION_LIMIT = 20;

    const DEFAULT_DASHBOARD_ORDER_BY = 'updated_at';
    const DEFAULT_DASHBOARD_ORDER_TYPE = 'desc';
    const DEFAULT_DASHBOARD_PAGINATION_LIMIT = 50;

    protected $guarded = ['id'];

    public $casts = [
        'publish_at' => 'datetime',
    ];

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
    | Events
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::forceDeleting(function ($record) {
            $record->knowledges()->detach();
            $record->categories()->detach();
            $record->likes()->delete();
            $record->favorites()->delete();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeOnlyVocabulary($query)
    {
        return $query->where('show_in_vocabulary', true)
            ->where('name', '!=', '');
    }

    /*
    |--------------------------------------------------------------------------
    | Queries
    |--------------------------------------------------------------------------
    */

    /**
     * Finalized query for the front based on the specified query and action.
     *
     * @param \Illuminate\Database\Eloquent\Builder|null $query The query builder instance (optional).
     * @param \Illuminate\Http\Request $request The HTTP request containing parameters like order, pagination, etc.
     * @param string $action The action to perform: 'paginate', 'get', or 'query'
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder
     *         The modified query or the retrieved results.
     */
    public static function finalizeQueryForFront($query, $request, $action)
    {
        $query = $query->onlyPublished();
        $query = self::finalizeQueryForRequest($query, $request, $action);

        return $query;
    }

    /**
     * Finalize vocabulary query for the front based on the specified query.
     *
     * @param \Illuminate\Database\Eloquent\Builder|null $query The query builder instance (optional).
     * @return \Illuminate\Pagination\LengthAwarePaginator Paginated results
     */
    public static function finalizeVocabularyQueryForFront($query)
    {
        $query = $query->onlyVocabulary()
            ->onlyPublished()
            ->select('id', 'name')
            ->withOnly([])
            ->orderBy('name', 'asc')
            ->get();

        return $query;
    }

    /**
     * Finalized query for the dashboard based on the specified query and action.
     *
     * @param \Illuminate\Database\Eloquent\Builder|null $query The query builder instance (optional).
     * @param \Illuminate\Http\Request $request The HTTP request containing parameters like order, pagination, etc.
     * @param string $action The action to perform: 'paginate', 'get', or 'query'
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder
     *         The modified query or the retrieved results.
     */
    public static function finalizeQueryForDashboard($query, $request, $action)
    {
        $query = $query->with(['knowledges']); // eager load knownledges
        $query = QueryFilterHelper::applyFilters($query, $request, self::getDashboardFilterConfig());
        $query = self::finalizeQueryForRequest($query, $request, $action);

        return $query;
    }

    public static function getAllNamedRecordsMinified()
    {
        return self::where('name', '!=', '')
            ->select('id', 'name')
            ->withOnly([])
            ->orderBy('name', 'asc')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Create and Update
    |--------------------------------------------------------------------------
    */

    public static function createFromRequest($request)
    {
        $record = self::create($request->all());

        // BelongsToMany relations
        $record->categories()->attach($request->input('categories'));
        $record->knowledges()->attach($request->input('knowledges'));
    }

    public function updateFromRequest($request)
    {
        $this->update($request->all());

        // BelongsToMany relations
        $this->categories()->sync($request->input('categories'));
        $this->knowledges()->sync($request->input('knowledges'));
    }

    /*
    |--------------------------------------------------------------------------
    | Miscellaneous
    |--------------------------------------------------------------------------
    */

    /**
     * Generate an associative array of subterms from the given terms collection.
     * Used in subterms text popup on term-cards subterm hover.
     *
     * @return array
     */
    public static function generateSubtermsArray($terms): array
    {
        // Extract subterms collections from each term
        $subtermsCollection = collect();

        foreach ($terms as $term) {
            $subtermsCollection->push($term->minified_subterms);
        }

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

    public static function getDashboardFilterConfig(): array
    {
        return [
            'whereEqual' => ['term_type_id', 'show_in_vocabulary'],
            'whereIn' => ['id'],
            'like' => ['body'],
            'belongsToMany' => ['categories', 'knowledges'],
            'dateRange' => ['created_at', 'updated_at', 'publish_at'],
        ];
    }
}
