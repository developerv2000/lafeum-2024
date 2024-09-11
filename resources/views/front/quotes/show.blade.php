@extends('front.layouts.app', [
    'bodyClass' => 'vocabulary-category',
    'includeRightbar' => true,
])

@section('leftbar')
    @include('front.leftbars.vocabulary')
@endsection

@section('content')
    <div class="vocabulary-category__about">
        <div class="vocabulary-category__about-inner">
            <x-front.different.about-page
                class="vocabulary-category__about-page"
                desc="На сегодня содержит более одной тысячи основных терминов, соответствующих тематике сайта. Для удобства термины дополнительно разбиты на темы. Большинство терминов взяты из Википедии с указанием ссылки на источник. В большинстве понятий имеются другие взаимосвязанные термины и ссылки. По мере обновления на основном источнике здесь они будут равным образом обновляться."
                include-search="true"
                search-selector=".vocabulary-list__link" />
        </div>
    </div>

    <div class="vocabulary-category__list-wrapper">
        <x-front.lists.vocabulary :record-chunks="$recordChunks" />
    </div>
@endsection
