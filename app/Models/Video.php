<?php

namespace App\Models;

use App\Support\Traits\Model\Favoriteable;
use App\Support\Traits\Model\Likeable;
use App\Support\Traits\Model\Publishable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Publishable;
    use Likeable;
    use Favoriteable;

    const PAGINATION_LIMIT_FOR_FRONT = 20;

    protected $guarded = ['id'];

    protected $with = [
        'channel:id,name,slug',
        'categories',
        'likes',
        'favorites',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function categories()
    {
        return $this->belongsToMany(VideoCategory::class, 'category_video', 'video_id', 'category_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Additional attributes
    |--------------------------------------------------------------------------
    */

    public function getYoutubeLinkAttribute()
    {
        return 'https://youtu.be/' . $this->youtube_id;
    }

    public function getEmbededYoutubeLinkAttribute()
    {
        return 'https://www.youtube.com/embed/' . $this->youtube_id;
    }

    public function getYoutubeThumbnailAttribute()
    {
        return 'https://i.ytimg.com/vi/' . $this->youtube_id . '/mqdefault.jpg';
    }

    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::forceDeleting(function ($item) {
            $item->categories()->detach();
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

    /*
    |--------------------------------------------------------------------------
    | Miscellaneous
    |--------------------------------------------------------------------------
    */

    public static function getYoutubeIdFromLink($link)
    {
        $youtubeIdRegEx = '/(?:youtube(?:-nocookie)?\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';

        $pregMatchOutput = [];

        $matched = preg_match($youtubeIdRegEx, $link, $pregMatchOutput);

        if ($matched && count($pregMatchOutput) === 2) {
            return $pregMatchOutput[1];
        }

        return null;
    }
}
