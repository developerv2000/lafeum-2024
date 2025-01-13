@extends('front.layouts.app', [
    'bodyClass' => 'videos-category',
    'includeRightbar' => true,
    'title' => $category->name,
])

@section('meta-tags')
    <meta name="description" content="{{ $category->share_text }}">
    <meta property="og:description" content="{{ $category->share_text }}">
    <meta property="og:title" content="{{ $category->name }}" />
    <meta property="og:image" content="{{ asset('img/main/share-logo.png') }}">
    <meta property="og:image:alt" content="ЛАФЕЮМ logo">
@endsection

@section('leftbar')
    @include('front.leftbars.videos')
@endsection

@section('content')
    <div class="videos-category__about">
        <div class="videos-category__about-inner">
            <x-front.different.about-page
                class="videos-category__about-page"
                :title="$category->name"
                :desc="$category->description" />
        </div>
    </div>

    <div class="videos-category__list-wrapper">
        <x-front.lists.videos :videos="$records" />
    </div>
@endsection
