<x-front.different.leftbar title="Термины по темам">
    <nav class="leftbar__nav thin-scrollbar">
        @foreach ($categories as $parent)
            <strong class="leftbar__nav-title @if ($loop->first) leftbar__nav-title--marginless @endif">{{ $parent->name }}</strong>

            @foreach ($parent->children as $child)
                <a @class([
                    'leftbar__nav-link',
                    'leftbar__nav-link--active' => isset($category) && $category->id == $child->id,
                ])
                    href="{{ route('terms.category', $child->slug) }}"
                    target="_blank">{{ $child->name }}</a>
            @endforeach
        @endforeach
    </nav>
</x-front.different.leftbar>
