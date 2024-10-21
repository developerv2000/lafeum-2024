<div class="keyworded-search">
    <form class="keyworded-search__form" action="{{ url()->current() }}" method="GET">
        <input class="input keyworded-search__input" type="text" name="keyword" value="{{ request()->input('keyword') }}" placeholder="Поиск...">
        <x-global.material-symbol-outlined class="keyworded-search__icon" icon="search"/>
    </form>
</div>
