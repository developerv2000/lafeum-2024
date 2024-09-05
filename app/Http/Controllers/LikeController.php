<?php

namespace App\Http\Controllers;

use App\Support\Helpers\ModelHelper;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Request $request)
    {
        $modelFullName = ModelHelper::addFullNameSpaceToModelBasename($request->route('model'));
        $record = $modelFullName::find($request->id);
        $record->toggleLikeByCurrentUser();

        return [
            'isLiked' => $record->isLikedByCurrentUser(),
            'likesCount' => $record->likesCount(),
        ];
    }
}
