@props(['record'])

<div class="like-container">
    <a href="{{ route('login') }}">
        <x-global.material-symbol-outlined
            class="like-container__icon"
            icon="favorite"
            filled="true" />
    </a>

    <p class="like-container__counter">{{ $record->likesCount() }}</p>
</div>
