@extends('front.layouts.app', [
    'bodyClass' => 'authors-show',
    'includeRightbar' => true,
    'title' => $author->name,
])

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
