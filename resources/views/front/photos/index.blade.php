@extends('front.layouts.app', [
    'bodyClass' => 'photos-index',
    'includeRightbar' => false,
    'title' => 'Фотографии',
])

@section('content')
    <div class="photos-index__about">
        <div class="photos-index__about-inner">
            <x-front.different.about-page
                title="Фотографии" />
        </div>
    </div>

    <div class="photos-index__list-wrapper">
        <x-front.lists.photos :photos="$records" />
    </div>
@endsection
