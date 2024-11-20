<?php

namespace App\Models;

use App\Support\Helpers\FileHelper;
use App\Support\Helpers\QueryFilterHelper;
use App\Support\Traits\Model\AddsQueryParamsToRequest;
use App\Support\Traits\Model\FinalizesQueryForRequest;
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
    use AddsQueryParamsToRequest;
    use FinalizesQueryForRequest;

    const DEFAULT_DASHBOARD_ORDER_BY = 'updated_at';
    const DEFAULT_DASHBOARD_ORDER_TYPE = 'desc';
    const DEFAULT_DASHBOARD_PAGINATION_LIMIT = 50;

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
        'registered_ip_address',
        'registered_browser',
        'registered_device',
        'registered_country',
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
            'settings' => 'array',
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

    public function getPhotoAssetUrlAttribute(): string
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

            $record->likes()->delete();
            $record->favorites()->delete();

            // Child folders will be removed automatically
            $record->rootFolders->each(function ($rootFolder) {
                $rootFolder->delete();
            });
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
    public function isAdministrator()
    {
        return $this->roles->contains('name', Role::ADMINISTRATOR_NAME);
    }

    /*
    |--------------------------------------------------------------------------
    | Queries
    |--------------------------------------------------------------------------
    */

    /**
     * Finalized query for the dashboard based on the specified query and action.
     *
     * @param \Illuminate\Database\Eloquent\Builder|null $query The query builder instance (optional).
     * @param \Illuminate\Http\Request $request The HTTP request containing parameters like order, pagination, etc.
     * @param string $action The action to perform: 'paginate', 'get', or 'query'
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder
     *         The modified query or the retrieved results.
     */
    public static function finalizeQueryForDashboard($query, $request, $action)
    {
        $query->with(['country', 'gender']);
        $query = QueryFilterHelper::applyFilters($query, $request, self::getDashboardFilterConfig());
        $query = self::finalizeQueryForRequest($query, $request, $action);

        return $query;
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

        $this->save();
    }

    public function updatePhoto($request)
    {
        // Upload photo
        $fullPath = $this->uploadFile('photo', public_path(self::PHOTO_PATH), $this->name, $request);

        // Resize photo
        FileHelper::resizeImage($fullPath, self::PHOTO_WIDTH, self::PHOTO_HEIGHT);
    }

    public function getLikedRecordsPaginated()
    {
        return $this->likes()->orderBy('id', 'desc')->with('likeable')->paginate(20);
    }

    public static function getCountryFromIP($ip)
    {
        $response = @file_get_contents('http://ipinfo.io/' . $ip . '/json');
        $details = json_decode($response);

        return $details->country ?? 'Unknown';
    }

    /**
     * Update the specified setting for the user.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function updateSetting($key, $value): void
    {
        $settings = $this->settings;
        $settings[$key] = $value;

        $this->settings = $settings;
        $this->save();
    }

    public static function getDashboardFilterConfig(): array
    {
        return [
            'whereEqual' => ['registered_ip_address', 'registered_browser', 'registered_device', 'registered_country', 'gender_id'],
            'whereIn' => ['id', 'country_id'],
            'like' => ['name', 'email'],
            'dateRange' => ['created_at', 'updated_at', 'publish_at'],
        ];
    }
}
