<?php

namespace App\Http\Controllers;

use App\Support\Helpers\ModelHelper;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function index(Request $request)
    {
        
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
