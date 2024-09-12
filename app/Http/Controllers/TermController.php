<?php

namespace App\Http\Controllers;

use App\Models\Term;
use App\Http\Requests\StoreTermRequest;
use App\Http\Requests\UpdateTermRequest;
use App\Models\TermCategory;

class TermController extends Controller
{
    public function index()
    {
        $records = Term::getFinalizedRecordsForFront();
        $subtermsArray = Term::generateSubtermsArray($records); // for subterms popup on hover
        $categories = TermCategory::get()->toTree(); // for leftbar

        return view('front.terms.index', compact('records', 'categories', 'subtermsArray'));
    }

    public function category(TermCategory $category)
    {
        $records = Term::getFinalizedRecordsForFront($category->terms());
        $subtermsArray = Term::generateSubtermsArray($records); // for subterms popup on hover
        $categories = TermCategory::get()->toTree(); // for leftbar

        return view('front.terms.category', compact('category', 'records', 'categories', 'subtermsArray'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Term $record)
    {
        $subtermsArray = Term::generateSubtermsArray(collect([$record])); // for subterms popup on hover

        return view('front.terms.show', compact('record', 'subtermsArray'));
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
    public function store(StoreTermRequest $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Term $term)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTermRequest $request, Term $term)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Term $term)
    {
        //
    }
}
