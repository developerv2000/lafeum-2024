@props(['orderBy', 'text'])

<a @class(['active' => request()->order_by == $orderBy]) href="{{ request()->reversedOrderUrl . '&order_by=' . $orderBy }}">
    <span>{{ $text }}</span>
    <x-global.material-symbol-outlined icon="expand_all" />
</a>
