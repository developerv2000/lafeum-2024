<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Quote;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = Author::getFinalizedRecordsForFront(Author::onlyPeople(), 'get');
        Author::prependNonPersonGroupLinks($records); // Prepend proverb & movie group links

        // Chunk records into 3 parts
        $totalRecords = $records->count();
        $recordChunks = $records->chunk(ceil($totalRecords / 3));

        return view('front.authors.index', compact('recordChunks'));
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        // Author can be instance of App\Models\Author or App\Models\AuthorGroup
        $author = Author::getAuthorBySlug($slug);

        switch (class_basename($author)) {
            case 'Author':
                $quotesQuery = $author->quotes();
                break;
            case 'AuthorGroup':
                $quotesQuery = $author->getQuotesQuery();
                break;
        }

        $quotes = Quote::getFinalizedRecordsForFront($quotesQuery);

        $authors = Author::getFinalizedRecordsForFront(Author::onlyPeople(), 'get'); // for leftbar
        Author::prependNonPersonGroupLinks($authors); // Prepend proverb & movie group links

        return view('front.authors.show', compact('author', 'quotes', 'authors'));
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
    public function store(StoreAuthorRequest $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequest $request, Author $author)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        //
    }
}
