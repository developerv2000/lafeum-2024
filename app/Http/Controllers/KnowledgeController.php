<?php

namespace App\Http\Controllers;

use App\Models\Knowledge;
use App\Http\Requests\StoreKnowledgeRequest;
use App\Http\Requests\UpdateKnowledgeRequest;
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
        $terms = $record->getTermsForFront();
        $knowledges = Knowledge::get()->toTree(); // for leftbar

        return view('front.knowledge.show', compact('record', 'terms', 'knowledges'));
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
    public function store(StoreKnowledgeRequest $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Knowledge $knowledge)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKnowledgeRequest $request, Knowledge $knowledge)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Knowledge $knowledge)
    {
        //
    }
}
