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
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function type()
    {
        return $this->belongsTo(TermType::class);
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
}
