@props(['orderBy', 'text'])

<a @class(['active' => request()->order_by == $orderBy]) href="{{ request()->reversed_order_url . '&order_by=' . $orderBy }}">
    <span>{{ $text }}</span>
    <x-global.material-symbol-outlined icon="expand_all" />
</a>
