@extends('front.layouts.app', [
    'bodyClass' => 'channels-show',
    'includeRightbar' => true,
    'title' => $record->name,
])

@section('leftbar')
    @include('front.leftbars.channels')
@endsection

@section('content')
    <div class="channels-show__about">
        <div class="channels-show__about-inner">
            <x-front.different.about-page
                title="{{ $record->name }}"
                :desc="$record->description" />
        </div>
    </div>

    <div class="channels-show__list-wrapper">
        <x-front.lists.videos :videos="$videos" />
    </div>
@endsection
