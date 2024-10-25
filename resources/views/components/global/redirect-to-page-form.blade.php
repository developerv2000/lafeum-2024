@props(['currentPage', 'lastPage'])

<form class="redirect-to-page-form" action="{{ route('redirect.to.page') }}" method="POST">
    @csrf
    <input type="hidden" name="full_url" value="{{ url()->full() }}">

    <label class="redirect-to-page-form__label" for="page">Перейти на страницу:</label>

    <input
        type="number"
        name="redirect_to_page"
        class="input redirect-to-page-form__input"
        min="1"
        max="{{ $lastPage }}"
        value="{{ $currentPage }}"
        required>

    <x-global.button style="shadowed" class="redirect-to-page-form__submit">Перейти</x-global.button>
</form>
