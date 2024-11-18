<?php

namespace App\Models;

use App\Support\Generators\SlugGenerator;
use App\Support\Traits\Model\GetsMinifiedRecordsWithName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Knowledge extends Model
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
        return $this->belongsToMany(Term::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::saving(function ($record) {
            $record->slug = SlugGenerator::generateUniqueSlug($record->name, self::class, $record->id);
        });

        static::deleting(function ($record) {
            $record->terms()->detach();

            
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Miscellaneous
    |--------------------------------------------------------------------------
    */

    public function getTermsForFront()
    {
        return Term::finalizeQueryForFront($this->terms(), request(), 'paginate');
    }
}
