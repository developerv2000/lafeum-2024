<?php

namespace App\Models;

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
}
