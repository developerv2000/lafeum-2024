<?php

namespace App\Models;

use App\Support\Traits\Model\Publishable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;
    use Publishable;

    const PAGINATION_LIMIT_FOR_FRONT = 16;

    const FOLDER_PATH = 'img/photos';
    const THUMBS_PATH = 'img/photos/thumbs';

    /*
    |--------------------------------------------------------------------------
    | Additional attributes
    |--------------------------------------------------------------------------
    */

    public function getAssetPathAttribute(): string
    {
        return asset(self::FOLDER_PATH . '/' . $this->filename);
    }

    public function getFilePathAttribute()
    {
        return public_path(self::FOLDER_PATH . '/' . $this->filename);
    }

    public function getThumbAssetPathAttribute(): string
    {
        return asset(self::THUMBS_PATH . '/' . $this->filename);
    }

    public function getThumbFilePathAttribute()
    {
        return public_path(self::THUMBS_PATH . '/' . $this->filename);
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
}
