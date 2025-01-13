@extends('front.layouts.app', [
    'bodyClass' => 'channels-show',
    'includeRightbar' => true,
    'title' => $record->name,
])

@section('meta-tags')
    <meta name="description" content="{{ $record->share_text }}">
    <meta property="og:description" content="{{ $record->share_text }}">
    <meta property="og:title" content="{{ $record->name }}" />
    <meta property="og:image" content="{{ asset('img/main/share-logo.png') }}">
    <meta property="og:image:alt" content="ЛАФЕЮМ logo">
@endsection

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
