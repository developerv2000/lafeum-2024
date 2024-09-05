@props(['record'])

<x-global.dropdown id="favorite-dropdown{{ $record->id }}" class="favorite-dropdown" button-style="transparent">
    <x-slot:button>
        <x-global.material-symbol-outlined
            :class="'favorite-dropdown__icon' . ($record->isFavoritedByCurrentUser() ? ' favorite-dropdown__icon--favorited' : '')"
            icon="bookmark"
            filled="true" />
    </x-slot:button>

    <x-slot:content>
        @auth
            <form
                class="favorite-form"
                action="{{ route('favorites.toggle', ['model' => class_basename($record), 'id' => $record->id]) }}"
                method="POST">

                @csrf

                <p class="favorite-form__title">Выберите папку:</p>

                {{-- Root folders --}}
                @foreach ($userRootFolders as $folder)
                    <div class="favorite-form__folder @if ($folder->hasChilds()) favorite-form__folder--has-children @endif">
                        <label class="favorite-form__label">
                            <input type="checkbox" value="{{ $folder->id }}" @checked($record->isFavoritedByCurrentUser())>
                            {{ $folder->name }}
                        </label>

                        {{-- Child folders --}}
                        @if ($folder->hasChilds())
                            <div class="favorite-form__folder-childs">
                                <p class="favorite-form__folder-childs-title">Подпапки:</p>

                                @foreach ($folder->childs as $child)
                                    <label class="favorite-form__label"><input type="checkbox" value="{{ $child->id }}" @checked($record->isFavoritedByCurrentUser($child->id))>
                                        {{ $child->name }}
                                    </label>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach

                {{-- Submit button --}}
                <x-global.button class="favorite-form__submit">Сохранить</x-global.button>
            </form>
        @endauth
    </x-slot:content>
</x-global.dropdown>
