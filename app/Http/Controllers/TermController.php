<?php

namespace App\Http\Controllers;

use App\Http\Requests\TermStoreRequest;
use App\Http\Requests\TermUpdateRequest;
use App\Models\Term;
use App\Models\TermCategory;
use App\Support\Helpers\UrlHelper;
use App\Support\Traits\Controller\DestroysModelRecords;
use App\Support\Traits\Controller\RestoresModelRecords;
use Illuminate\Http\Request;

class TermController extends Controller
{
    use DestroysModelRecords;
    use RestoresModelRecords;

    public static $model = Term::class; // Required in multiple destroy/restore traits

    /*
    |--------------------------------------------------------------------------
    | Front actions
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        Term::addFrontQueryParamsToRequest($request);
        $records = Term::finalizeQueryForFront(Term::query(), $request, 'paginate');
        $subtermsArray = Term::generateSubtermsArray($records); // Used in subterms text popup on term-cards subterm hover.
        $categories = TermCategory::get()->toTree(); // for leftbar

        return view('front.terms.index', compact('records', 'categories', 'subtermsArray'));
    }

    public function category(Request $request, TermCategory $category)
    {
        Term::addFrontQueryParamsToRequest($request);
        $records = Term::finalizeQueryForFront($category->terms(), $request, 'paginate');
        $subtermsArray = Term::generateSubtermsArray($records); // Used in subterms text popup on term-cards subterm hover.
        $categories = TermCategory::get()->toTree(); // for leftbar

        return view('front.terms.category', compact('category', 'records', 'categories', 'subtermsArray'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Term $record)
    {
        $subtermsArray = Term::generateSubtermsArray(collect([$record])); // Used in subterms text popup on term-cards subterm hover.

        return view('front.terms.show', compact('record', 'subtermsArray'));
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard actions
    |--------------------------------------------------------------------------
    */

    public function dashboardIndex(Request $request)
    {
        Term::addDashboardQueryParamsToRequest($request);
        UrlHelper::addUrlWithReversedOrderTypeToRequest($request);
        $records = Term::finalizeQueryForDashboard(Term::query(), $request, 'paginate');

        return view('dashboard.terms.index', compact('records'));
    }

    public function dashboardTrash(Request $request)
    {
        Term::addDashboardQueryParamsToRequest($request);
        UrlHelper::addUrlWithReversedOrderTypeToRequest($request);
        $records = Term::finalizeQueryForDashboard(Term::onlyTrashed(), $request, 'paginate');

        return view('dashboard.terms.trash', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function dashboardCreate()
    {
        return view('dashboard.terms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function dashboardStore(TermStoreRequest $request)
    {
        Term::createFromRequest($request);

        return to_route('dashboard.terms.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * Route model binding not used, because trashed records can also be edited.
     * Route model binding looks only for untrashed records!
     */
    public function dashboardEdit(Request $request, $record)
    {
        $record = Term::withTrashed()->findOrFail($record);

        return view('dashboard.terms.edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     *
     * Route model binding not used, because trashed records can also be updated.
     * Route model binding looks only for untrashed records!
     */
    public function dashboardUpdate(TermUpdateRequest $request, Term $record)
    {
        $record = Term::withTrashed()->findOrFail($record);
        $record->updateFromRequest($request);

        return redirect($request->input('previous_url'));
    }
}
