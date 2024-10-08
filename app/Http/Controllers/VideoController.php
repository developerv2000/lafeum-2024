<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use App\Models\VideoCategory;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = Video::getFinalizedRecordsForFront();
        $categories = VideoCategory::get()->toTree(); // for leftbar

        return view('front.videos.index', compact('records', 'categories'));
    }

    public function category(VideoCategory $category)
    {
        $records = Video::getFinalizedRecordsForFront($category->videos());
        $categories = VideoCategory::get()->toTree(); // for leftbar

        return view('front.videos.category', compact('category', 'records', 'categories'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $record)
    {
        return view('front.videos.show', compact('record'));
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
    public function store(StoreVideoRequest $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVideoRequest $request, Video $video)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        //
    }
}
