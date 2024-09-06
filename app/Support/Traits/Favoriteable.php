<?php

namespace App\Support\Traits;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Model;

trait Favoriteable
{
    /**
     * Get all favorites for the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    /**
     * Check if the model is favorited by the current authenticated user.
     *
     * @param  int|null  $folderId
     * @return bool
     */
    public function isFavoritedByCurrentUser(?int $folderId = null): bool
    {
        $query = $this->favorites()->where('user_id', auth()->id());

        if ($folderId !== null) {
            $query->where('folder_id', $folderId);
        }

        return $query->exists();
    }

    /**
     * Add a favorite from the current authenticated user.
     *
     * @param  int  $folderId
     * @return \Illuminate\Database\Eloquent\Model|bool
     */
    public function favoriteByCurrentUser(int $folderId)
    {
        if (!$this->isFavoritedByCurrentUser($folderId)) {
            return $this->favorites()->create([
                'user_id' => auth()->id(),
                'folder_id' => $folderId,
            ]);
        }

        return false;
    }

    /**
     * Remove the favorite from the current authenticated user.
     *
     * @param  int  $folderId
     * @return bool|null
     */
    public function unfavoriteByCurrentUser(int $folderId): ?bool
    {
        if ($this->isFavoritedByCurrentUser($folderId)) {
            return $this->favorites()
                ->where('user_id', auth()->id())
                ->where('folder_id', $folderId)
                ->delete();
        }

        return false;
    }

    /**
     * Toggle favorite status for the current authenticated user.
     *
     * @param  int  $folderId
     * @return \Illuminate\Database\Eloquent\Model|bool|null
     */
    public function toggleFavoriteByCurrentUser(int $folderId)
    {
        if ($this->isFavoritedByCurrentUser($folderId)) {
            return $this->unfavoriteByCurrentUser($folderId);
        }

        return $this->favoriteByCurrentUser($folderId);
    }

    /**
     * Count the number of favorites for the model.
     *
     * @return int
     */
    public function favoritesCount(): int
    {
        return $this->favorites()->count();
    }

    public function refreshFavoritesFromRequest($request)
    {
        // Remove old favorites
        $this->favorites()->where('user_id', auth()->id())->delete();

        // Attach new ones
        $folderIDs = $request->input('folder_ids', []);

        foreach ($folderIDs as $folderID) {
            $this->favoriteByCurrentUser($folderID);
        }
    }
}
