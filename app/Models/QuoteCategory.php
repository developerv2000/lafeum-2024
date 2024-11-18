<?php

namespace App\Models;

use App\Support\Traits\Model\GetsMinifiedRecordsWithName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class QuoteCategory extends Model
{
    use HasFactory;
    use NodeTrait;
    use GetsMinifiedRecordsWithName;

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
}
