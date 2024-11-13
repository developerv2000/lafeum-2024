<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class QuoteCategory extends Model
{
    use HasFactory;
    use NodeTrait;

    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function quotes()
    {
        return $this->belongsToMany(Quote::class, 'category_quote', 'category_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Queries
    |--------------------------------------------------------------------------
    */

    public static function getAllMinified()
    {
        return self::select('id', 'name')
            ->orderBY('name', 'asc')
            ->get();
    }
}
