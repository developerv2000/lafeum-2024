@extends('front.layouts.app', [
    'bodyClass' => 'knowledge-show',
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
    @include('front.leftbars.knowledge')
@endsection

@section('content')
    <div class="knowledge-show__about">
        <div class="knowledge-show__about-inner">
            <x-front.different.about-page
                class="knowledge-show__about-page"
                title="{{ $record->name }}"
                :desc="$record->description" />
        </div>
    </div>

    <x-front.lists.terms :terms="$terms" :subterms-array="$subtermsArray" />
@endsection
