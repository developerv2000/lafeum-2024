@extends('front.layouts.app', [
    'bodyClass' => 'terms-index',
    'includeRightbar' => true,
    'title' => 'Термины',
])

@section('leftbar')
    @include('front.leftbars.terms')
@endsection

@section('content')
    <div class="terms-index__about">
        <div class="terms-index__about-inner">
            <x-front.different.about-page
                title="Термины"
                class="terms-index__about-page" />
        </div>
    </div>

    <div class="terms-index__list-wrapper">
        <x-front.lists.terms :terms="$records" :subterms-array="$subtermsArray" />
    </div>
@endsection
