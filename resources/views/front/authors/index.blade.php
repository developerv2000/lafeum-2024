@extends('front.layouts.app', [
    'bodyClass' => 'authors-index',
    'includeRightbar' => true,
])

@section('content')
    <div class="authors-index__about">
        <div class="authors-index__about-inner">
            <x-front.different.about-page
                class="authors-index__about-page"
                title="Авторы"
                desc="Полный список всех авторов по алфавиту, а также есть возможность поиска."
                include-search="true"
                search-selector=".authors-list__link" />
        </div>
    </div>

    <div class="authors-index__list-wrapper">
        <x-front.lists.authors :recordChunks="$recordChunks" />
    </div>
@endsection
