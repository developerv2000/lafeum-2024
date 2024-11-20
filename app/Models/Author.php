<?php

namespace App\Models;

use App\Support\Generators\SlugGenerator;
use App\Support\Helpers\QueryFilterHelper;
use App\Support\Traits\Model\AddsQueryParamsToRequest;
use App\Support\Traits\Model\FinalizesQueryForRequest;
use App\Support\Traits\Model\GetsMinifiedRecordsWithName;
use App\Support\Traits\Model\UploadsFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasFactory;
    use SoftDeletes;
    use GetsMinifiedRecordsWithName;
    use AddsQueryParamsToRequest;
    use FinalizesQueryForRequest;
    use UploadsFile;

    const DEFAULT_FRONT_ORDER_BY = 'name';
    const DEFAULT_FRONT_ORDER_TYPE = 'asc';
    const DEFAULT_FRONT_PAGINATION_LIMIT = 20;

    const DEFAULT_DASHBOARD_ORDER_BY = 'updated_at';
    const DEFAULT_DASHBOARD_ORDER_TYPE = 'desc';
    const DEFAULT_DASHBOARD_PAGINATION_LIMIT = 50;

    const PHOTO_PATH = 'img/authors';

    protected $guarded = ['id'];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function group()
    {
        return $this->belongsTo(AuthorGroup::class, 'author_group_id');
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

    public function getPhotoAssetUrlAttribute(): string
    {
        return asset(self::PHOTO_PATH . '/' . $this->photo);
    }

    public function getPhotoFilePathAttribute()
    {
        return public_path(self::PHOTO_PATH . '/' . $this->photo);
    }

    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::saving(function ($record) {
            if ($record->isDirty('name')) {
                $record->slug = SlugGenerator::generateUniqueSlug($record->name, self::class, $record->id);
            }
        });

        // Trashing
        static::deleting(function ($record) {
            $record->quotes->each(function ($quote) {
                $quote->delete();
            });
        });

        static::forceDeleting(function ($record) {
            $record->quotes()->withTrashed()->get()->each(function ($quote) {
                $quote->forceDelete();
            });
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
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
        $query = $query->with(['group'])->withCount('quotes');
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

        // Upload photo
        $record->uploadFile('photo', public_path(self::PHOTO_PATH), $record->slug, $request);
    }

    public function updateFromRequest($request)
    {
        $this->update($request->all());

        // Upload photo if exists
        $this->uploadFile('photo', public_path(self::PHOTO_PATH), $this->slug, $request);
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

    public static function getDashboardFilterConfig(): array
    {
        return [
            'whereEqual' => ['id', 'author_group_id'],
            'like' => ['name'],
            'dateRange' => ['created_at', 'updated_at'],
        ];
    }
}
