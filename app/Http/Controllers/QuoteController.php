<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Http\Requests\StoreQuoteRequest;
use App\Http\Requests\UpdateQuoteRequest;
use App\Models\QuoteCategory;
use App\Support\Traits\Controller\DestroysModelRecords;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    use DestroysModelRecords;

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
        Quote::addQueryParamsToRequest($request);
        $records = Quote::finalizeQueryForFront(Quote::query(), $request, 'paginate');

        $categories = QuoteCategory::get()->toTree(); // for leftbar

        return view('front.quotes.index', compact('records', 'categories'));
    }

    public function category(Request $request, QuoteCategory $category)
    {
        Quote::addQueryParamsToRequest($request);
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
        Quote::addQueryParamsToRequest($request);
        $records = Quote::finalizeQueryForDashboard(Quote::query(), $request, 'paginate');

        return view('dashboard.quotes.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function dashboardCreate()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function dashboardStore(StoreQuoteRequest $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function dashboardEdit(Quote $record)
    {
        return view('dashboard.quotes.edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function dashboardUpdate(UpdateQuoteRequest $request, Quote $quote)
    {
        //
    }
}
