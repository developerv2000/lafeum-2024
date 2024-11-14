@props(['currentPage', 'lastPage'])

<form class="navigate-to-page-number" action="{{ route('navigate.to.page.number') }}" method="POST">
    @csrf
    <input type="hidden" name="full_url" value="{{ url()->full() }}">

    <label class="navigate-to-page-number__label" for="navigate_to_page">Перейти на страницу:</label>

    <input
        class="input navigate-to-page-number__input"
        id="navigate_to_page"
        type="number"
        name="navigate_to_page"
        min="1"
        max="{{ $lastPage }}"
        value="{{ $currentPage }}"
        required>

    <x-global.button style="shadowed" class="navigate-to-page-number__submit">Перейти</x-global.button>
</form>
