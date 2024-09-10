<?php

namespace App\Http\Controllers;

use App\Models\Term;
use App\Models\TermCategory;
use Illuminate\Http\Request;

class VocabularyController extends Controller
{
    public function index()
    {
        $records = Term::getFinalizedVocabularyRecordsForFront();

        // Chunk records by half
        $totalRecords = $records->count();
        $recordChunks = $records->chunk(ceil($totalRecords / 2));

        $categories = TermCategory::get()->toTree(); // for leftbar

        return view('front.vocabulary.index', compact('recordChunks', 'categories'));
    }

    /**
     * AJAX request
     */
    public function getBody(Request $request)
    {
        $term = Term::find($request->term_id);

        return $term->body;
    }
}
