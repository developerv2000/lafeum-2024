@extends('front.layouts.app', [
    'bodyClass' => 'quotes-category',
    'includeRightbar' => true,
])

@section('leftbar')
    @include('front.leftbars.quotes')
@endsection

@section('content')
    <div class="quotes-category__about">
        <div class="quotes-category__about-inner">
            <x-front.different.about-page
                class="quotes-category__about-page"
                :title="$category->name"
                :desc="$category->description" />
        </div>
    </div>

    <div class="quotes-category__list-wrapper">
        <x-front.lists.quotes :quotes="$records" />
    </div>
@endsection
