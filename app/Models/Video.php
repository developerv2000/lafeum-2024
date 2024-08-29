<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function channel()
    {
        return $this->belongsTo(Channel::class);
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
