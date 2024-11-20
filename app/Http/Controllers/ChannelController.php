<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChannelStoreRequest;
use App\Http\Requests\ChannelUpdateRequest;
use App\Models\Channel;
use App\Models\Video;
use App\Support\Helpers\UrlHelper;
use App\Support\Traits\Controller\DestroysModelRecords;
use App\Support\Traits\Controller\RestoresModelRecords;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    use DestroysModelRecords;
    use RestoresModelRecords;

    public static $model = Channel::class; // Required in multiple destroy/restore traits

    /*
    |--------------------------------------------------------------------------
    | Front actions
    |--------------------------------------------------------------------------
    */

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = Channel::getAllMinified();

        // Chunk records into 3 parts
        $totalRecords = $records->count();
        $recordChunks = $records->chunk(ceil($totalRecords / 3));

        return view('front.channels.index', compact('recordChunks'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Channel $record)
    {
        $channels = Channel::getAllMinified(); // for leftbar

        Video::addFrontQueryParamsToRequest($request);
        $videos = Video::finalizeQueryForFront($record->videos(), $request, 'paginate');

        return view('front.channels.show', compact('record', 'videos', 'channels'));
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard actions
    |--------------------------------------------------------------------------
    */

    public function dashboardIndex(Request $request)
    {
        Channel::addDashboardQueryParamsToRequest($request);
        UrlHelper::addUrlWithReversedOrderTypeToRequest($request);
        $records = Channel::finalizeQueryForDashboard(Channel::query(), $request, 'paginate');

        return view('dashboard.channels.index', compact('records'));
    }

    public function dashboardTrash(Request $request)
    {
        Channel::addDashboardQueryParamsToRequest($request);
        UrlHelper::addUrlWithReversedOrderTypeToRequest($request);
        $records = Channel::finalizeQueryForDashboard(Channel::onlyTrashed(), $request, 'paginate');

        return view('dashboard.channels.trash', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function dashboardCreate()
    {
        return view('dashboard.channels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function dashboardStore(ChannelStoreRequest $request)
    {
        Channel::createFromRequest($request);

        return to_route('dashboard.channels.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * Route model binding not used, because trashed records can also be edited.
     * Route model binding looks only for untrashed records!
     */
    public function dashboardEdit(Request $request, $record)
    {
        $record = Channel::withTrashed()->findOrFail($record);

        return view('dashboard.channels.edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     *
     * Route model binding not used, because trashed records can also be updated.
     * Route model binding looks only for untrashed records!
     */
    public function dashboardUpdate(ChannelUpdateRequest $request, $record)
    {
        $record = Channel::withTrashed()->findOrFail($record);
        $record->updateFromRequest($request);

        return redirect($request->input('previous_url'));
    }
}
