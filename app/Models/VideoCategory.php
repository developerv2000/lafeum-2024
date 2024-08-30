<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class VideoCategory extends Model
{
    use HasFactory;
    use NodeTrait;

    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function videos()
    {
        return $this->belongsToMany(Video::class, 'category_video', 'category_id');
    }
}
