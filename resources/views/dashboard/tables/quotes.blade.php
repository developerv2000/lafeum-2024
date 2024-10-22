<table class="main-table">
    {{-- Head start --}}
    <thead>
        <tr>
            <x-dashboard.table.th.select-all />
            <x-dashboard.table.th.view />
            <x-dashboard.table.th.edit />
            <x-dashboard.table.th.delete />

            <th width="220">
                <x-dashboard.table.th.order-link order-by="author_id" text="Автор" />
            </th>

            <th>Цитата</th>

            <th width="200">Категории</th>

            <th width="220">
                <x-dashboard.table.th.order-link order-by="notes" text="Мысли автора" />
            </th>

            <th width="170">
                <x-dashboard.table.th.order-link order-by="publish_at" text="Опубликовано" />
            </th>
        </tr>
    </thead> {{-- Head end --}}

    <tbody>
        @foreach ($records as $record)
            <tr>
                <x-dashboard.table.td.checkbox :value="$record->value" />

                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>
