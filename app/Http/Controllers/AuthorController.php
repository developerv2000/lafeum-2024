<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorStoreRequest;
use App\Http\Requests\AuthorUpdateRequest;
use App\Models\Author;
use App\Models\Quote;
use App\Support\Helpers\UrlHelper;
use App\Support\Traits\Controller\DestroysModelRecords;
use App\Support\Traits\Controller\RestoresModelRecords;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    use DestroysModelRecords;
    use RestoresModelRecords;

    public static $model = Author::class; // Required in multiple destroy/restore traits

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
        $records = Author::getAllMinified();
        Author::prependNonPersonGroupLinks($records); // Prepend proverb & movie group links

        // Chunk records into 3 parts
        $totalRecords = $records->count();
        $recordChunks = $records->chunk(ceil($totalRecords / 3));

        return view('front.authors.index', compact('recordChunks'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $slug)
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

        // Get author quotes
        Quote::addFrontQueryParamsToRequest($request);
        $quotes = Quote::finalizeQueryForFront($quotesQuery, $request, 'paginate');

        $authors = Author::getAllMinified(); // for leftbar
        Author::prependNonPersonGroupLinks($authors); // Prepend proverb & movie group links

        return view('front.authors.show', compact('author', 'quotes', 'authors'));
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard actions
    |--------------------------------------------------------------------------
    */

    public function dashboardIndex(Request $request)
    {
        Author::addDashboardQueryParamsToRequest($request);
        UrlHelper::addUrlWithReversedOrderTypeToRequest($request);
        $records = Author::finalizeQueryForDashboard(Author::query(), $request, 'paginate');

        return view('dashboard.authors.index', compact('records'));
    }

    public function dashboardTrash(Request $request)
    {
        Author::addDashboardQueryParamsToRequest($request);
        UrlHelper::addUrlWithReversedOrderTypeToRequest($request);
        $records = Author::finalizeQueryForDashboard(Author::onlyTrashed(), $request, 'paginate');

        return view('dashboard.authors.trash', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function dashboardCreate()
    {
        return view('dashboard.authors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function dashboardStore(AuthorStoreRequest $request)
    {
        Author::createFromRequest($request);

        return to_route('dashboard.authors.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * Route model binding not used, because trashed records can also be edited.
     * Route model binding looks only for untrashed records!
     */
    public function dashboardEdit(Request $request, $record)
    {
        $record = Author::withTrashed()->findOrFail($record);

        return view('dashboard.authors.edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     *
     * Route model binding not used, because trashed records can also be updated.
     * Route model binding looks only for untrashed records!
     */
    public function dashboardUpdate(AuthorUpdateRequest $request, $record)
    {
        $record = Author::withTrashed()->findOrFail($record);
        $record->updateFromRequest($request);

        return redirect($request->input('previous_url'));
    }
}
