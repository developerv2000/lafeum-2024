<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    const ADMINISTRATOR_NAME = 'Администратор';
    const AUTHOR_NAME = 'Автор';
    const USER_NAME = 'Пользователь';

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Querying
    |--------------------------------------------------------------------------
    */
    
    public static function findByName($name)
    {
        return self::where('name', $name)->firstOrFail();
    }
}
