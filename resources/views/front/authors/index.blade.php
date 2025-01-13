@extends('front.layouts.app', [
    'bodyClass' => 'authors-index',
    'includeRightbar' => true,
    'title' => 'Авторы',
])

@section('meta-tags')
    <meta name="description" content="Полный список всех авторов по алфавиту, а также есть возможность поиска.">
    <meta property="og:description" content="Полный список всех авторов по алфавиту, а также есть возможность поиска.">
    <meta property="og:title" content="Авторы" />
    <meta property="og:image" content="{{ asset('img/main/share-logo.png') }}">
    <meta property="og:image:alt" content="ЛАФЕЮМ logo">
@endsection

@section('content')
    <div class="authors-index__about">
        <div class="authors-index__about-inner">
            <x-front.different.about-page
                class="authors-index__about-page"
                title="Авторы"
                desc="Полный список всех авторов по алфавиту, а также есть возможность поиска."
                include-search="true"
                search-placeholder="Введите имя автора"
                search-selector=".authors-list__link" />
        </div>
    </div>

    <div class="authors-index__list-wrapper">
        <x-front.lists.authors :recordChunks="$recordChunks" />
    </div>
@endsection
