<div class="manage-folders__list">
    @foreach ($rootFolders as $root)
        {{-- Root folder --}}
        <div class="manage-folders__list-item manage-folders__list-item--root">
            <x-global.material-symbol-outlined icon="folder_open" filled="1" />
            <a class="manage-folders__list-link" href="{{ route('folders.show', $root->id) }}">{{ $root->name }}</a>
            <x-front.lists.partials.manage-folder-actions :folder="$root" />
        </div>

        {{-- Childs --}}
        @if ($root->childs->count())
            <div class="manage-folders__list-childs-wrapper">
                @foreach ($root->childs as $child)
                    <div class="manage-folders__list-item manage-folders__list-item--child">
                        <x-global.material-symbol-outlined icon="sort" filled="1" />
                        <a class="manage-folders__list-link" href="{{ route('folders.show', $child->id) }}">{{ $child->name }}</a>
                        <x-front.lists.partials.manage-folder-actions :folder="$child" />
                    </div>
                @endforeach
            </div>
        @endif
    @endforeach
</div>
