<?php

namespace App\Models;

use App\Support\Helpers\GeneralHelper;
use App\Support\Helpers\QueryFilterHelper;
use App\Support\Traits\Model\AddsQueryParamsToRequest;
use App\Support\Traits\Model\Favoriteable;
use App\Support\Traits\Model\FinalizesQueryForRequest;
use App\Support\Traits\Model\FormatsAttributeForDateTimeInput;
use App\Support\Traits\Model\Likeable;
use App\Support\Traits\Model\Publishable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Publishable;
    use Likeable;
    use Favoriteable;
    use AddsQueryParamsToRequest;
    use FinalizesQueryForRequest;
    use FormatsAttributeForDateTimeInput;

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
        'author:id,name,slug,photo',
        'categories',
        'likes',
        'favorites',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function author()
    {
        return $this->belongsTo(Author::class)->withTrashed();
    }

    public function categories()
    {
        return $this->belongsToMany(QuoteCategory::class, 'category_quote', 'quote_id', 'category_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Additional attributes
    |--------------------------------------------------------------------------
    */

    public function getShareTextAttribute()
    {
        return GeneralHelper::generateShareTextFromStr($this->body);
    }

    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::restored(function ($record) {
            if ($record->author->trashed()) {
                $record->author->restoreQuietly();
            }
        });

        // Trashing
        static::deleting(function ($record) {
            $record->likes()->delete();
            $record->favorites()->delete();
        });

        static::forceDeleting(function ($record) {
            $record->categories()->detach();
            $record->likes()->delete();
            $record->favorites()->delete();
        });
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
        $query = QueryFilterHelper::applyFilters($query, $request, self::getDashboardFilterConfig());
        $query = self::finalizeQueryForRequest($query, $request, $action);

        return $query;
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
    }

    public function updateFromRequest($request)
    {
        $this->update($request->all());

        // BelongsToMany relations
        $this->categories()->sync($request->input('categories'));
    }

    /*
    |--------------------------------------------------------------------------
    | Miscellaneous
    |--------------------------------------------------------------------------
    */

    public static function getDashboardFilterConfig(): array
    {
        return [
            'whereIn' => ['id', 'author_id'],
            'like' => ['body', 'notes'],
            'belongsToMany' => ['categories'],
            'dateRange' => ['created_at', 'updated_at', 'publish_at'],
        ];
    }
}
