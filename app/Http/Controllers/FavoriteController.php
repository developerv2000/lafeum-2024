<?php

namespace App\Http\Controllers;

use App\Support\Helpers\ModelHelper;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function refresh(Request $request)
    {
        $modelFullName = ModelHelper::addFullNameSpaceToModelBasename($request->route('model'));
        $record = $modelFullName::find($request->id);
        $record->refreshFavoritesFromRequest($request);

        return [
            'isFavorited' => $record->isFavoritedByCurrentUser(),
        ];
    }
}
