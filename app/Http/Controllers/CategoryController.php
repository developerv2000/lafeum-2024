<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Support\Helpers\ModelHelper;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public $namespacedModel;

    public function __construct(Request $request)
    {
        $this->namespacedModel = ModelHelper::addFullNamespaceToModelBasename($request->route('model'));
    }

    public function dashboardIndex(Request $request, $model)
    {
        $records = $this->namespacedModel::with('parent')
            ->withRecordsCount()
            ->orderBy('name', 'asc')
            ->paginate(40)
            ->appends($request->except('page'));

        return view('dashboard.categories.index', compact('records', 'model'));
    }

    public function dashboardCreate(Request $request, $model)
    {
        $roots = $this->namespacedModel::whereIsRoot()->get();

        return view('dashboard.categories.create', compact('roots', 'model'));
    }

    public function dashboardStore(CategoryStoreRequest $request, $model)
    {
        $attributes = $request->except(['parent_id']);
        $this->namespacedModel::create($attributes, $this->namespacedModel::find($request->parent_id));

        return redirect()->route('dashboard.categories.index', compact('model'));
    }

    public function dashboardEdit(Request $request, $model, $recordID)
    {
        $record = $this->namespacedModel::find($recordID);
        $roots = $this->namespacedModel::whereIsRoot()->get();

        return view('dashboard.categories.edit', compact('record', 'roots', 'model'));
    }

    public function dashboardUpdate(CategoryUpdateRequest $request, $model, $recordID)
    {
        $record = $this->namespacedModel::find($recordID);
        $record->update($request->all()); // Nestedset tree updates automatically on record update

        return redirect($request->input('previous_url'));
    }

    public function editNestedset(Request $request, $model)
    {
        $records = $this->namespacedModel::defaultOrder()->get()->toTree();

        return view('dashboard.categories.edit-nestedset', compact('records', 'model'));
    }

    public function updateNestedset(Request $request, $model)
    {
        // Extract record IDs from the request
        $recordIDs = collect($request->records_array)->pluck('id');

        // Fetch IDs of records to be removed
        $removedrecords = $this->namespacedModel::whereNotIn('id', $recordIDs)->get();

        // Separate child and parent nodes for proper deletion order
        $childNodes = [];
        $parentNodes = [];

        foreach ($removedrecords as $record) {
            if ($record->parent_id) {
                $childNodes[] = $record;
            } else {
                $parentNodes[] = $record;
            }
        }

        // Delete child nodes first
        foreach ($childNodes as $child) {
            $child->delete();
        }

        // Then delete parent nodes
        foreach ($parentNodes as $parent) {
            $parent->delete();
        }

        // Rebuild the tree with the provided hierarchy
        $this->namespacedModel::rebuildTree($request->record_hierarchy, false);

        return true;
    }
}
