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
}
