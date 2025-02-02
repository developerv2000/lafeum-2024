<?php

namespace App\Models;

use App\Support\Generators\SlugGenerator;
use App\Support\Helpers\GeneralHelper;
use App\Support\Traits\Model\GetsMinifiedRecordsWithName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class TermCategory extends Model
{
    use HasFactory;
    use NodeTrait;
    use GetsMinifiedRecordsWithName;

    public $timestamps = false;

    protected $guarded = ['id'];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function terms()
    {
        return $this->belongsToMany(Term::class, 'category_term', 'category_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Additional attributes
    |--------------------------------------------------------------------------
    */

    public function getShareTextAttribute()
    {
        return GeneralHelper::generateShareTextFromStr($this->description);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopewithRecordsCount($query)
    {
        return $query->withCount('terms as records_count');
    }

    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::saving(function ($record) {
            if ($record->isDirty('name')) {
                $record->slug = SlugGenerator::generateUniqueSlug($record->name, self::class, $record->id);
            }
        });

        // Child records will be removed automatically
        static::deleting(function ($record) {
            $record->terms()->detach();
        });
    }
}
