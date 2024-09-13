@extends('front.layouts.app', [
    'bodyClass' => 'videos-category',
    'includeRightbar' => true,
])

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
