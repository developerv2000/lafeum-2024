@extends('front.layouts.app', [
    'bodyClass' => 'authors-show',
    'includeRightbar' => true,
    'title' => $author->name,
])

{{-- If not AuthorGroup --}}
@if (class_basename($author) == 'Author')
    @section('meta-tags')
        <meta name="description" content="{{ $author->share_text }}">
        <meta property="og:description" content="{{ $author->share_text }}">
        <meta property="og:title" content="{{ $author->name }}" />
        <meta property="og:image" content="{{ $author->photo_asset_url }}">
        <meta property="og:image:alt" content="{{ $author->name }}">
    @endsection
@endif

@section('leftbar')
    @include('front.leftbars.authors')
@endsection

@section('content')
    <div class="authors-show__card-wrapper">
        <x-front.cards.authors :author="$author" />
    </div>

    <div class="authors-show__list-wrapper">
        <x-front.lists.quotes :quotes="$quotes" />
    </div>
@endsection
