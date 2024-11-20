<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuoteStoreRequest;
use App\Http\Requests\QuoteUpdateRequest;
use App\Models\Quote;
use App\Models\QuoteCategory;
use App\Support\Helpers\UrlHelper;
use App\Support\Traits\Controller\DestroysModelRecords;
use App\Support\Traits\Controller\RestoresModelRecords;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    use DestroysModelRecords;
    use RestoresModelRecords;

    public static $model = Quote::class; // Required in multiple destroy/restore traits

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
        Quote::addFrontQueryParamsToRequest($request);
        $records = Quote::finalizeQueryForFront(Quote::query(), $request, 'paginate');

        $categories = QuoteCategory::get()->toTree(); // for leftbar

        return view('front.quotes.index', compact('records', 'categories'));
    }

    public function category(Request $request, QuoteCategory $category)
    {
        Quote::addFrontQueryParamsToRequest($request);
        $records = Quote::finalizeQueryForFront($category->quotes(), $request, 'paginate');

        $categories = QuoteCategory::get()->toTree(); // for leftbar

        return view('front.quotes.category', compact('category', 'records', 'categories'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Quote $record)
    {
        return view('front.quotes.show', compact('record'));
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard actions
    |--------------------------------------------------------------------------
    */

    public function dashboardIndex(Request $request)
    {
        Quote::addDashboardQueryParamsToRequest($request);
        UrlHelper::addUrlWithReversedOrderTypeToRequest($request);
        $records = Quote::finalizeQueryForDashboard(Quote::query(), $request, 'paginate');

        return view('dashboard.quotes.index', compact('records'));
    }

    public function dashboardTrash(Request $request)
    {
        Quote::addDashboardQueryParamsToRequest($request);
        UrlHelper::addUrlWithReversedOrderTypeToRequest($request);
        $records = Quote::finalizeQueryForDashboard(Quote::onlyTrashed(), $request, 'paginate');

        return view('dashboard.quotes.trash', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function dashboardCreate()
    {
        return view('dashboard.quotes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function dashboardStore(QuoteStoreRequest $request)
    {
        Quote::createFromRequest($request);

        return to_route('dashboard.quotes.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * Route model binding not used, because trashed records can also be edited.
     * Route model binding looks only for untrashed records!
     */
    public function dashboardEdit(Request $request, $record)
    {
        $record = Quote::withTrashed()->findOrFail($record);

        return view('dashboard.quotes.edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     *
     * Route model binding not used, because trashed records can also be updated.
     * Route model binding looks only for untrashed records!
     */
    public function dashboardUpdate(QuoteUpdateRequest $request, $record)
    {
        $record = Quote::withTrashed()->findOrFail($record);
        $record->updateFromRequest($request);

        return redirect($request->input('previous_url'));
    }
}
