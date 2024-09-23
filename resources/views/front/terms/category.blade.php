@extends('front.layouts.app', [
    'bodyClass' => 'terms-category',
    'includeRightbar' => true,
    'title' => $category->name,
])

@section('leftbar')
    @include('front.leftbars.terms')
@endsection

@section('content')
    <div class="terms-category__about">
        <div class="terms-category__about-inner">
            <x-front.different.about-page
                class="terms-category__about-page"
                :title="$category->name"
                :desc="$category->description" />
        </div>
    </div>

    <div class="terms-category__list-wrapper">
        <x-front.lists.terms :terms="$records" :subterms-array="$subtermsArray" />
    </div>
@endsection
