<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyPost extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = ['id'];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Querying
    |--------------------------------------------------------------------------
    */

    /**
     * Used in rightbar
     */
    public static function getLatestRecord()
    {
        return self::orderBy('id', 'desc')
            ->with([
                'quote' => function ($query) {
                    $query->withOnly(['author']);
                },

                'term' => function ($query) {
                    $query->withOnly([]);
                },

                'video' => function ($query) {
                    $query->withOnly([]);
                },

                'photo' => function ($query) {
                    $query->withOnly([]);
                },

            ])
            ->first();
    }

    /*
    |--------------------------------------------------------------------------
    | Miscellaneous
    |--------------------------------------------------------------------------
    */

    public static function createNewRandomly()
    {
        self::create([
            'date' => now(),
            'quote_id' => Quote::onlyPublished()->inRandomOrder()->first()->id,
            'term_id' => Term::onlyPublished()->inRandomOrder()->first()->id,
            'video_id' => Video::onlyPublished()->inRandomOrder()->first()->id,
            'photo_id' => Photo::onlyPublished()->inRandomOrder()->first()->id
        ]);
    }
}
