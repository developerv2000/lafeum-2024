<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermType extends Model
{
    use HasFactory;

    const SCIENTIFIC_TERMS = 'Термины научного мира';
    const EXPERT_COMMENTS = 'Комментарии специалистов';

    public $timestamp = false;

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function terms()
    {
        return $this->hasMany(Term::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Miscellaneous
    |--------------------------------------------------------------------------
    */

    public function isScientific()
    {
        return $this->name === self::SCIENTIFIC_TERMS;
    }

    public function isExpertComments()
    {
        return $this->name === self::EXPERT_COMMENTS;
    }
}
