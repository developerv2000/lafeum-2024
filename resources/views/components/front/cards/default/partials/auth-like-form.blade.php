@props(['record'])

<div class="like-container">
    <form class="like-form" action="{{ route('likes.toggle', ['model' => class_basename($record), 'id' => $record->id]) }}" method="POST">
        <button class="button button--transparent like-container__button">
            <x-global.material-symbol-outlined
                :class="'like-container__icon' . ($record->isLikedByCurrentUser() ? ' like-container__icon--liked' : '')"
                icon="favorite"
                filled="true" />
        </button>
    </form>

    <p class="like-container__counter">{{ $record->likesCount() }}</p>
</div>
