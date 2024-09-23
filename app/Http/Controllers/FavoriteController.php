<?php

namespace App\Http\Controllers;

use App\Support\Helpers\ModelHelper;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $rootFolders = $request->user()->rootFolders;

        return view('front.pages.favorites', compact('rootFolders'));
    }

    public function refresh(Request $request)
    {
        $modelFullName = ModelHelper::addFullNameSpaceToModelBasename($request->route('model'));
        $record = $modelFullName::find($request->id);
        $record->refreshFavoritesFromRequest($request);
        $record->refresh();

        return [
            'isFavorited' => $record->isFavoritedByCurrentUser(),
        ];
    }
}
