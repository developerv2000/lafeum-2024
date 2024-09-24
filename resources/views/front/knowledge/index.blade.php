@extends('front.layouts.app', [
    'bodyClass' => 'knowledge-index',
    'includeRightbar' => true,
    'title' => 'Области знаний',
])

@section('content')
    <section class="knowledge-index__about">
        <div class="knowledge-index__about-inner">
            <x-front.different.about-page
                class="knowledge-index__about-page"
                title="Области знаний"
                desc="В этой рубрике термины и комментарии специалистов классифицированы более развернуто по группам и направлениям."
                include-search="true"
                search-placeholder="Введите область знаний"
                search-selector=".knowledge-blocks__subcategories-link" />
        </div>
    </section>

    <section class="knowledge-blocks">
        <div class="knowledge-blocks__categories-wrapper">
            @foreach ($records as $record)
                <div class="knowledge-blocks__category">
                    <h2 class="main-title knowledge-blocks__category-title">{{ $record->name }}</h2>

                    <nav class="knowledge-blocks__subcategories-nav">
                        @foreach ($record->children as $child)
                            <a class="knowledge-blocks__subcategories-link" href="{{ route('knowledge.show', $child->slug) }}" target="_blank">{{ $child->name }}</a>
                        @endforeach
                    </nav>
                </div>
            @endforeach
        </div>
    </section>
@endsection
