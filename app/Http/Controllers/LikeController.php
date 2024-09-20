<?php

namespace App\Http\Controllers;

use App\Models\Term;
use App\Support\Helpers\ModelHelper;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $records = $user->getLikedRecordsPaginated();

        // Generate subterms array for subterm popup on hover
        $terms = $records->where('likeable_type', 'App\Models\Term')->pluck('likeable');
        $subtermsArray = Term::generateSubtermsArray($terms);

        return view('front.pages.likes', compact('records', 'subtermsArray'));
    }

    public function toggle(Request $request)
    {
        $modelFullName = ModelHelper::addFullNameSpaceToModelBasename($request->route('model'));
        $record = $modelFullName::find($request->id);
        $record->toggleLikeByCurrentUser();
        $record->refresh();

        return [
            'isLiked' => $record->isLikedByCurrentUser(),
            'likesCount' => $record->likesCount(),
        ];
    }
}
