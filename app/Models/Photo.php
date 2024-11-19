<?php

namespace App\Models;

use App\Support\Helpers\FileHelper;
use App\Support\Helpers\QueryFilterHelper;
use App\Support\Traits\Model\AddsQueryParamsToRequest;
use App\Support\Traits\Model\FinalizesQueryForRequest;
use App\Support\Traits\Model\Publishable;
use App\Support\Traits\Model\UploadsFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Photo extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Publishable;
    use AddsQueryParamsToRequest;
    use FinalizesQueryForRequest;
    use UploadsFile;

    const DEFAULT_FRONT_ORDER_BY = 'publish_at';
    const DEFAULT_FRONT_ORDER_TYPE = 'desc';
    const DEFAULT_FRONT_PAGINATION_LIMIT = 16;

    const DEFAULT_DASHBOARD_ORDER_BY = 'updated_at';
    const DEFAULT_DASHBOARD_ORDER_TYPE = 'desc';
    const DEFAULT_DASHBOARD_PAGINATION_LIMIT = 50;

    const FOLDER_PATH = 'img/photos';
    const THUMBS_PATH = 'img/photos/thumbs';

    const THUMB_WIDTH = 420;
    const THUMB_HEIGHT = null;

    protected $guarded = ['id'];

    public $casts = [
        'publish_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Additional attributes
    |--------------------------------------------------------------------------
    */
    public function getAssetUrlAttribute(): string
    {
        return asset(self::FOLDER_PATH . '/' . $this->filename);
    }

    public function getFileSystemPathAttribute(): string
    {
        return public_path(self::FOLDER_PATH . '/' . $this->filename);
    }

    public function getThumbAssetUrlAttribute(): string
    {
        return asset(self::THUMBS_PATH . '/' . $this->filename);
    }

    public function getThumbFileSystemPathAttribute(): string
    {
        return public_path(self::THUMBS_PATH . '/' . $this->filename);
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

        // Upload file and create thumbnail
        $record->uploadFile('filename', public_path(self::FOLDER_PATH), $record->id, $request);
        $record->createThumbnail();
    }

    public function updateFromRequest($request)
    {
        $this->update($request->all());

        if ($request->has('filename')) {
            $this->uploadFile('filename', public_path(self::FOLDER_PATH), $this->id, $request);
            $this->createThumbnail();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Miscellaneous
    |--------------------------------------------------------------------------
    */

    public function createThumbnail()
    {
        $photoPath = public_path(self::FOLDER_PATH . '/' . $this->filename);
        $thumbPath = public_path(self::THUMBS_PATH . '/' . $this->filename);
        FileHelper::createThumbnail($photoPath, $thumbPath, self::THUMB_WIDTH, self::THUMB_HEIGHT);
    }
}
