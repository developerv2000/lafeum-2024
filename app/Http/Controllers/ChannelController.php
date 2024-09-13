<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Http\Requests\StoreChannelRequest;
use App\Http\Requests\UpdateChannelRequest;
use App\Models\Video;
use App\Models\VideoCategory;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = Channel::getFinalizedRecordsForFront(null, 'get');

        // Chunk records into 3 parts
        $totalRecords = $records->count();
        $recordChunks = $records->chunk(ceil($totalRecords / 3));

        return view('front.channels.index', compact('recordChunks'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Channel $record)
    {
        $videos = Video::getFinalizedRecordsForFront($record->videos());
        $channels = Channel::getFinalizedRecordsForFront(null, 'get'); // for leftbar

        return view('front.channels.show', compact('record', 'videos', 'channels'));
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
    public function store(StoreChannelRequest $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Channel $channel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChannelRequest $request, Channel $channel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Channel $channel)
    {
        //
    }
}
