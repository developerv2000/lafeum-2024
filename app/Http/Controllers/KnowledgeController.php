<?php

namespace App\Http\Controllers;

use App\Models\Knowledge;
use App\Http\Requests\StoreKnowledgeRequest;
use App\Http\Requests\UpdateKnowledgeRequest;
use App\Models\Term;
use Illuminate\Http\Request;

class KnowledgeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = Knowledge::get()->toTree();

        return view('front.knowledge.index', compact('records'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Knowledge $record)
    {
        Term::addQueryParamsToRequest($request);
        $terms = $record->getTermsForFront();
        $subtermsArray = Term::generateSubtermsArray($terms); // for subterms popup on hover
        $knowledges = Knowledge::get()->toTree(); // for leftbar

        return view('front.knowledge.show', compact('record', 'terms', 'subtermsArray', 'knowledges'));
    }
}
