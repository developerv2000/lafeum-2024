@extends('front.layouts.app', [
    'bodyClass' => 'channels-index',
    'includeRightbar' => true,
])

@section('content')
    <div class="channels-index__about">
        <div class="channels-index__about-inner">
            <x-front.different.about-page
                class="channels-index__about-page"
                title="Каналы"
                desc="Каналы. Полный список всех авторов по алфавиту, а также есть возможность поиска."
                include-search="true"
                search-selector=".channels-list__link" />
        </div>
    </div>

    <div class="channels-index__list-wrapper">
        <x-front.lists.channels :recordChunks="$recordChunks" />
    </div>
@endsection
