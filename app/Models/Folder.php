<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = ['id'];
    protected $with = ['childs'];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function childs()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::deleting(function ($record) {
            $record->childs()->delete();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Miscellaneous
    |--------------------------------------------------------------------------
    */

    public function hasChilds()
    {
        return $this->childs->count();
    }

    public function getFavoritesPaginated()
    {
        return $this->favorites()->orderBy('id', 'desc')->with('favoritable')->paginate(20);
    }
}
