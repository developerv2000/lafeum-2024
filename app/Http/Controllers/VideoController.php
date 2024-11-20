<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoStoreRequest;
use App\Http\Requests\VideoUpdateRequest;
use App\Models\Video;
use App\Models\VideoCategory;
use App\Support\Helpers\UrlHelper;
use App\Support\Traits\Controller\DestroysModelRecords;
use App\Support\Traits\Controller\RestoresModelRecords;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    use DestroysModelRecords;
    use RestoresModelRecords;

    public static $model = Video::class; // Required in multiple destroy/restore traits

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
        Video::addFrontQueryParamsToRequest($request);
        $records = Video::finalizeQueryForFront(Video::query(), $request, 'paginate');

        $categories = VideoCategory::get()->toTree(); // for leftbar

        return view('front.videos.index', compact('records', 'categories'));
    }

    public function category(VideoCategory $category, Request $request)
    {
        Video::addFrontQueryParamsToRequest($request);
        $records = Video::finalizeQueryForFront($category->videos(), $request, 'paginate');

        $categories = VideoCategory::get()->toTree(); // for leftbar

        return view('front.videos.category', compact('category', 'records', 'categories'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $record)
    {
        return view('front.videos.show', compact('record'));
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard actions
    |--------------------------------------------------------------------------
    */

    public function dashboardIndex(Request $request)
    {
        Video::addDashboardQueryParamsToRequest($request);
        UrlHelper::addUrlWithReversedOrderTypeToRequest($request);
        $records = Video::finalizeQueryForDashboard(Video::query(), $request, 'paginate');

        return view('dashboard.videos.index', compact('records'));
    }

    public function dashboardTrash(Request $request)
    {
        Video::addDashboardQueryParamsToRequest($request);
        UrlHelper::addUrlWithReversedOrderTypeToRequest($request);
        $records = Video::finalizeQueryForDashboard(Video::onlyTrashed(), $request, 'paginate');

        return view('dashboard.videos.trash', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function dashboardCreate()
    {
        return view('dashboard.videos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function dashboardStore(VideoStoreRequest $request)
    {
        Video::createFromRequest($request);

        return to_route('dashboard.videos.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * Route model binding not used, because trashed records can also be edited.
     * Route model binding looks only for untrashed records!
     */
    public function dashboardEdit(Request $request, $record)
    {
        $record = Video::withTrashed()->findOrFail($record);

        return view('dashboard.videos.edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function dashboardUpdate(VideoUpdateRequest $request, Video $record)
    {
        $record->updateFromRequest($request);

        return redirect($request->input('previous_url'));
    }
}
