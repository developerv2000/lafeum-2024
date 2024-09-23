@extends('front.layouts.app', [
    'bodyClass' => 'knowledge-show',
    'includeRightbar' => true,
    'title' => $record->name,
])

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
