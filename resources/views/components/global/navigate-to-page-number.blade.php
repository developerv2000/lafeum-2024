@props(['currentPage', 'lastPage'])

<form class="navigate-to-page-number" action="{{ route('navigate.to.page.number') }}" method="POST">
    @csrf
    <input type="hidden" name="full_url" value="{{ url()->full() }}">

    <label class="navigate-to-page-number__label" for="page">Перейти на страницу:</label>

    <input
        type="number"
        name="navigate_to_page"
        class="input navigate-to-page-number__input"
        min="1"
        max="{{ $lastPage }}"
        value="{{ $currentPage }}"
        required>

    <x-global.button style="shadowed" class="navigate-to-page-number__submit">Перейти</x-global.button>
</form>
