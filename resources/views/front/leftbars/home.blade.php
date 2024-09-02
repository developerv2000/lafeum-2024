<x-front.different.leftbar class="home-leftbar" title="Темы">
    @foreach ($rootCategories as $category)
        <div class="accordion">
            {{-- Root category --}}
            <div class="accordion__item">
                <button class="accordion__button">
                    <span class="accordion__button-text"><strong>{{ $category->name }}</strong></span>
                </button>

                <div class="accordion__content">
                    @foreach ($category->supported_type_links as $link)
                        <a href="{{ $link['href'] }}" target="_blank">{{ $link['label'] }}</a>
                    @endforeach
                </div>
            </div>

            {{-- Child categories --}}
            @foreach ($category->children as $child)
                <div class="accordion__item">
                    <button class="accordion__button">
                        <span class="accordion__button-text">{{ $child->name }}</span>
                    </button>

                    <div class="accordion__content">
                        @foreach ($child->supported_type_links as $link)
                            <a href="{{ $link['href'] }}" target="_blank">{{ $link['label'] }}</a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</x-front.different.leftbar>
