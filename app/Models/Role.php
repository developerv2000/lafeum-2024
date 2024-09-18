<?php

namespace App\Models;

use App\Support\Traits\Model\FindsRecordByName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    use FindsRecordByName;

    const ADMINISTRATOR_NAME = 'Администратор';
    const AUTHOR_NAME = 'Автор';
    const USER_NAME = 'Пользователь';

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
