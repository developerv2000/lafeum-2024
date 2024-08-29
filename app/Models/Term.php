<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function termType()
    {
        return $this->belongsTo(TermType::class);
    }

    public function knowledges()
    {
        return $this->belongsToMany(Knowledge::class);
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

    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::forceDeleting(function ($item) {
            // $item->categories()->detach();
            $item->knowledges()->detach();
        });
    }
}
