@extends('front.layouts.app', [
    'bodyClass' => 'channels-index',
    'includeRightbar' => true,
    'title' => 'Каналы YouTube',
])

@section('meta-tags')
    <meta name="description" content="Полный список всех авторов по алфавиту, а также есть возможность поиска.">
    <meta property="og:description" content="Полный список всех авторов по алфавиту, а также есть возможность поиска.">
    <meta property="og:title" content="Каналы YouTube" />
    <meta property="og:image" content="{{ asset('img/main/share-logo.png') }}">
    <meta property="og:image:alt" content="ЛАФЕЮМ logo">
@endsection

@section('content')
    <div class="channels-index__about">
        <div class="channels-index__about-inner">
            <x-front.different.about-page
                class="channels-index__about-page"
                title="Каналы"
                desc="Каналы. Полный список всех авторов по алфавиту, а также есть возможность поиска."
                include-search="true"
                search-placeholder="Введите название канала"
                search-selector=".channels-list__link" />
        </div>
    </div>

    <div class="channels-index__list-wrapper">
        <x-front.lists.channels :recordChunks="$recordChunks" />
    </div>
@endsection
