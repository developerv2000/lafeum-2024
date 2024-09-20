<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Term;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    public function show(Request $request, Folder $record)
    {
        $favorites = $record->getFavoritesPaginated();

        // Generate subterms array for subterm popup on hover
        $terms = $favorites->where('favoritable_type', 'App\Models\Term')->pluck('favoritable');
        $subtermsArray = Term::generateSubtermsArray($terms);

        return view('front.pages.folder', compact('record', 'favorites', 'subtermsArray'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'parent_id' => 'nullable|integer',
        ]);

        $request->user()->folders()->create([$validatedData]);

        return redirect()->back();
    }

    public function update(Request $request, Folder $record)
    {
        // Escape hacks
        $hasAccess = $request->user()->folders()->where('id', $record->id)->exists();

        if (!$hasAccess) {
            abort(404);
        }

        // Update record
        $record->update([
            'name' => $request->input('name'),
        ]);

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $folder = $request->user()->folders()->where('id', $request->id)->firstOrFail();
        $folder->delete();

        return redirect()->back();
    }
}
