<?php

namespace App\Models;

use App\Support\Traits\Favoriteable;
use App\Support\Traits\Likeable;
use App\Support\Traits\Publishable;
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
        return 'https://youtu.be/' . $this->host_id;
    }

    public function getEmbededYoutubeLinkAttribute()
    {
        return 'https://www.youtube.com/embed/' . $this->host_id;
    }

    public function getYoutubeThumbnailAttribute()
    {
        return 'https://i.ytimg.com/vi/' . $this->host_id . '/mqdefault.jpg';
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
    | Miscellaneous
    |--------------------------------------------------------------------------
    */

    public static function getHostIdFromYoutubeLink($link)
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
