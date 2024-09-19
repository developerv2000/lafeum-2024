<?php

namespace App\Models;

use App\Support\Helpers\FileHelper;
use App\Support\Traits\Model\UploadsFile;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    use UploadsFile;

    const PHOTO_PATH = 'img/users';
    const DEFAULT_PHOTO_NAME = '__default__.png';
    const PHOTO_WIDTH = 320;
    const PHOTO_HEIGHT = 320;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'birthday',
        'gender_id',
        'country_id',
        'biography',
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
            // 'birthday' => 'date',
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
    | Roles Check
    |--------------------------------------------------------------------------
    */

    /**
     * All privileges
     */
    public function isAdmin()
    {
        return $this->roles->contains('name', Role::ADMINISTRATOR_NAME);
    }

    /*
    |--------------------------------------------------------------------------
    | Miscellaneous
    |--------------------------------------------------------------------------
    */

    public function updateProfileFromRequest($request)
    {
        $this->fill($request->safe()->except('photo'));

        // Handle email update
        if ($this->isDirty('email')) {
            $this->email_verified_at = null;
            $this->sendEmailVerificationNotification();
        }

        // Handle photo update
        if ($request->hasFile('photo')) {
            $this->updatePhoto($request);
        }

        $this->save();
    }

    public function updatePhoto($request)
    {
        // Upload photo
        $fullPath = $this->uploadFile('photo', public_path(self::PHOTO_PATH), $this->name, $request);

        // Resize photo
        FileHelper::resizeImage($fullPath, self::PHOTO_WIDTH, self::PHOTO_HEIGHT);
    }
}
