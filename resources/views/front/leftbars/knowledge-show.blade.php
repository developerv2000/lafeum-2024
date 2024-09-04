<x-front.different.leftbar title="Область знаний" subtitle="Поиск" include-search="true" search-placeholder="Введите область знаний">
    <nav class="leftbar__nav thin-scrollbar">
        @foreach ($knowledges as $parent)
            <b class="leftbar__nav-title @if($loop->first) leftbar__nav-title--marginless @endif">{{ $parent->name }}</b>

            @foreach ($parent->children as $child)
                <a class="leftbar__nav-link" href="{{ route('knowledge.show', $child->slug) }}" target="_blank">{{ $child->name }}</a>
            @endforeach
        @endforeach
    </nav>
</x-front.different.leftbar>
