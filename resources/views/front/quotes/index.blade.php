@extends('front.layouts.app', [
    'bodyClass' => 'quotes-index',
    'includeRightbar' => true,
    'title' => 'Цитаты и Афоризмы',
])

@section('meta-tags')
    <meta name="description" content="Лучшие цитаты, афоризмы и высказывания великих ученых и мыслителей, и успешных людей на тематику сайта.">
    <meta property="og:description" content="Лучшие цитаты, афоризмы и высказывания великих ученых и мыслителей, и успешных людей на тематику сайта.">
    <meta property="og:title" content="Цитаты и Афоризмы" />
    <meta property="og:image" content="{{ asset('img/main/share-logo.png') }}">
    <meta property="og:image:alt" content="ЛАФЕЮМ logo">
@endsection

@section('leftbar')
    @include('front.leftbars.quotes')
@endsection

@section('content')
    <div class="quotes-index__about">
        <div class="quotes-index__about-inner">
            <x-front.different.about-page
                class="quotes-index__about-page"
                title="Цитаты и Афоризмы"
                desc="Лучшие цитаты, афоризмы и высказывания великих ученых и мыслителей, и успешных людей на тематику сайта." />
        </div>
    </div>

    <div class="quotes-index__list-wrapper">
        <x-front.lists.quotes :quotes="$records" />
    </div>
@endsection
