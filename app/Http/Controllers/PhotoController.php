<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhotoStoreRequest;
use App\Http\Requests\PhotoUpdateRequest;
use App\Models\Photo;
use App\Support\Traits\Controller\DestroysModelRecords;
use App\Support\Traits\Controller\RestoresModelRecords;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    use DestroysModelRecords;
    use RestoresModelRecords;

    public static $model = Photo::class; // Required in multiple destroy/restore traits

    /*
    |--------------------------------------------------------------------------
    | Front actions
    |--------------------------------------------------------------------------
    */

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Photo::addQueryParamsToRequest($request);
        $records = Photo::finalizeQueryForFront(Photo::query(), $request, 'paginate');

        return view('front.photos.index', compact('records'));
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard actions
    |--------------------------------------------------------------------------
    */

    public function dashboardIndex(Request $request)
    {
        Photo::addQueryParamsToRequest($request);
        $records = Photo::finalizeQueryForDashboard(Photo::query(), $request, 'paginate');

        return view('dashboard.photos.index', compact('records'));
    }

    public function dashboardTrash(Request $request)
    {
        Photo::addQueryParamsToRequest($request);
        $records = Photo::finalizeQueryForDashboard(Photo::onlyTrashed(), $request, 'paginate');

        return view('dashboard.photos.trash', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function dashboardCreate()
    {
        return view('dashboard.photos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function dashboardStore(Request $request)
    {
        Photo::createFromRequest($request);

        return to_route('dashboard.photos.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * Route model binding not used, because trashed records can also be edited.
     * Route model binding looks only for untrashed records!
     */
    public function dashboardEdit(Request $request, $record)
    {
        $record = Photo::withTrashed()->findOrFail($record);

        return view('dashboard.photos.edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function dashboardUpdate(PhotoUpdateRequest $request, Photo $record)
    {
        $record->updateFromRequest($request);

        return redirect($request->input('previous_url'));
    }
}
