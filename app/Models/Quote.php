<?php

namespace App\Models;

use App\Support\Traits\Model\AddsModelQueryParamsToRequest;
use App\Support\Traits\Model\Favoriteable;
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
    use AddsModelQueryParamsToRequest;

    const PAGINATION_LIMIT_FOR_FRONT = 20;

    const DEFAULT_DASHBOARD_ORDER_BY = 'updated_at';
    const DEFAULT_DASHBOARD_ORDER_TYPE = 'desc';
    const DEFAULT_DASHBOARD_PAGINATION_LIMIT = 40;

    protected $guarded = ['id'];

    protected $with = [
        'author:id,name,slug',
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
        return $this->belongsTo(Author::class);
    }

    public function categories()
    {
        return $this->belongsToMany(QuoteCategory::class, 'category_quote', 'quote_id', 'category_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::forceDeleting(function ($record) {
            $record->categories()->detach();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Queries
    |--------------------------------------------------------------------------
    */

    /**
     * Get finalized records for the front-end based on the specified query and action.
     *
     * @param \Illuminate\Database\Eloquent\Builder|null $query The query builder instance (optional).
     * @param string $action The action to perform: 'paginate', 'get', or 'query'.
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder
     *         The modified query or the retrieved results.
     */
    public static function getFinalizedRecordsForFront($query = null, $action = 'paginate')
    {
        // Use the provided query or default to a new query.
        $query = $query ?: self::query();

        // Apply common query modifications
        $query->onlyPublished()
            ->orderBy('publish_at', 'desc');

        // Handle the different action: paginate, get, or return the query itself.
        switch ($action) {
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
     * Get finalized records for the dashboard based on the specified query and action.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing parameters like order, pagination, etc.
     * @param \Illuminate\Database\Eloquent\Builder|null $query The query builder instance (optional).
     * @param string $action The action to perform: 'paginate', 'get', or 'query'. Defaults to 'paginate'.
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder
     *         The modified query or the retrieved results.
     */
    public static function getFinalizedRecordsForDashboard($request, $query = null, $action = 'paginate')
    {
        // Use the provided query or default to a new query.
        $query = $query ?: self::query();

        // Apply sorting based on request parameters
        $query->orderBy($request->order_by, $request->order_type)
            ->orderBy('id', $request->order_type); // Secondary ordering by 'id'.

        // Handle the different actions: paginate, get, or return the query itself.
        switch ($action) {
            case 'paginate':
                return $query->paginate($request->pagination_limit, ['*'], 'page', $request->get('page', 1))
                    ->appends($request->except(['page', 'reversed_order_url']));

            case 'get':
                return $query->get();

            case 'query':
            default:
                return $query;
        }
    }
}
