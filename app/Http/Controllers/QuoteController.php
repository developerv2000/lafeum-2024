<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Http\Requests\StoreQuoteRequest;
use App\Http\Requests\UpdateQuoteRequest;
use App\Models\QuoteCategory;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = Quote::getFinalizedRecordsForFront();
        $categories = QuoteCategory::get()->toTree(); // for leftbar

        return view('front.quotes.index', compact('records', 'categories'));
    }

    public function category(QuoteCategory $category)
    {
        $records = Quote::getFinalizedRecordsForFront($category->quotes());
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuoteRequest $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quote $quote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuoteRequest $request, Quote $quote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quote $quote)
    {
        //
    }
}
