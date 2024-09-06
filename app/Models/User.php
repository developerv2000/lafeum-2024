<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    const PHOTO_PATH = 'img/users';
    const DEFAULT_PHOTO_NAME = '__default__.png';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birthday' => 'date',
        ];
    }

    protected $with = [
        'roles',
        'rootFolders',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function folders()
    {
        return $this->hasMany(Folder::class)->orderBy('name', 'asc');
    }

    public function rootFolders()
    {
        return $this->folders()->whereNull('parent_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Mutators & additional attributes
    |--------------------------------------------------------------------------
    */

    /**
     * Get the user's photo attribute.
     */
    protected function photo(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ?: self::DEFAULT_PHOTO_NAME,
        );
    }

    public function getPhotoAssetPathAttribute(): string
    {
        return asset(self::PHOTO_PATH . '/' . $this->photo);
    }

    public function getPhotoFilePathAttribute()
    {
        return public_path(self::PHOTO_PATH . '/' . $this->photo);
    }

    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::deleting(function ($record) {
            $record->roles()->detach();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Miscellaneous
    |--------------------------------------------------------------------------
    */

    public function loadRootFolders()
    {
        if (!$this->loaded_root_folders) {
            $this->loaded_root_folders = $this->rootFolders;
        }
    }
}
