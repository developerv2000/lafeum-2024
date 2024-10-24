<aside class="rightbar thin-scrollbar styled-box">
    <div class="filter">
        <div class="filter__header">
            <h3 class="filter__title">Фильтр</h3>

            <a class="filter__reset" title="Сбросить" href="{{ url()->current() }}">
                <x-global.material-symbol-outlined class="filter__reset-icon" icon="restart_alt" />
            </a>
        </div>


        <form class="form filter-form" action="{{ url()->current() }}" method="GET">
            {{-- Keep current ordering --}}
            <input type="hidden" name="order_by" value="{{ request()->order_by }}">
            <input type="hidden" name="order_type" value="{{ request()->order_type }}">

            {{ $slot }}

            <x-global.button type="submit" class="fiter-form__submit">Обновить</x-global.button>
        </form>
    </div>
</aside>
