@extends('front.layouts.app', [
    'bodyClass' => 'videos-index',
    'includeRightbar' => true,
    'title' => 'Видео',
])

@section('leftbar')
    @include('front.leftbars.videos')
@endsection

@section('content')
    <div class="videos-index__about">
        <div class="videos-index__about-inner">
            <x-front.different.about-page
                title="Видео"
                class="videos-index__about-page" />
        </div>
    </div>

    <div class="videos-index__list-wrapper">
        <x-front.lists.videos :videos="$records" />
    </div>
@endsection
