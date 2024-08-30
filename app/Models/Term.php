<?php

namespace App\Models;

use App\Support\Traits\Favoriteable;
use App\Support\Traits\Likeable;
use App\Support\Traits\Publishable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Term extends Model
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

    public function type()
    {
        return $this->belongsTo(TermType::class);
    }

    public function knowledges()
    {
        return $this->belongsToMany(Knowledge::class);
    }

    public function categories()
    {
        return $this->belongsToMany(TermCategory::class, 'category_term', 'term_id', 'category_id');
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
            $item->knowledges()->detach();
            $item->categories()->detach();
        });
    }
}
