@extends('front.layouts.app', [
    'bodyClass' => 'knowledge-show',
    'includeRightbar' => true,
])

@section('leftbar')
    @include('front.leftbars.knowledge-show')
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

    
@endsection
