<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorGroup extends Model
{
    use HasFactory;

    const PEOPLE_NAME = 'Автор';

    const MOVIES_NAME = 'Фильмы и Сериалы';
    const MOVIES_SLUG = 'filmy-i-serialy';
    const MOVIES_BIOGRAPHY = 'Фильмы и Сериалы. Здесь собраны лучшие высказывания и цитаты из фильмов и сериалов всех времен.';

    const PROVERBS_NAME = 'Пословицы и поговорки';
    const PROVERBS_SLUG = 'poslovicy-i-pogovorki';
    const PROVERBS_BIOGRAPHY = 'Пословицы и поговорки. Коллекция пословиц и поговорок народов мира. В них собраны плоды опытности народов и здравый смысл.';

    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function authors()
    {
        return $this->hasMany(Author::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Additional attributes
    |--------------------------------------------------------------------------
    */

    /**
     * Used in authors.show page while AuthorGroup is used instead of Author
     */
    public function getBiographyAttribute()
    {
        switch ($this->name) {
            case self::MOVIES_NAME:
                return self::MOVIES_BIOGRAPHY;
                break;
            case self::PROVERBS_NAME:
                return self::PROVERBS_BIOGRAPHY;
                break;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Queries
    |--------------------------------------------------------------------------
    */

    public static function findByName($name)
    {
        return self::where('name', $name)->firstOrFail();
    }

    public function getQuotesQuery()
    {
        switch ($this->name) {
            case self::MOVIES_NAME:
                $authorIDs = Author::onlyMovies()->pluck('id');
                break;
            case self::PROVERBS_NAME:
                $authorIDs = Author::onlyProverbs()->pluck('id');
                break;
        }

        $quotesQuery = Quote::whereIn('author_id', $authorIDs);

        return $quotesQuery;
    }
}
