<x-dashboard.table.main-template :records="$records">
    {{-- thead titles --}}
    <x-slot:thead-titles>
        <x-dashboard.table.th.select-all />
        <x-dashboard.table.th.edit />
        <x-dashboard.table.th.view />
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
    </x-slot:thead-titles>

    {{-- tbody rows --}}
    <x-slot:tbody-rows>
        @foreach ($records as $record)
            <tr>
                <x-dashboard.table.td.checkbox :value="$record->value" />
                <x-dashboard.table.td.edit :link="route('dashboard.quotes.edit', $record->id)" />
                <x-dashboard.table.td.view :link="route('quotes.show', $record->id)" />
                <x-dashboard.table.td.delete />

                <td>{{ $record->author->name }}</td>
                <td><x-dashboard.table.td.max-lines-limited-text :text="$record->body" /></td>

                <td>
                    <div class="badges-wrapper">
                        @foreach ($record->categories as $category)
                            <span class="badge badge--orange">{{ $category->name }}</span>
                        @endforeach
                    </div>
                </td>

                <td><x-dashboard.table.td.max-lines-limited-text :text="$record->notes" /></td>
                <td>{{ $record->publish_at->isoFormat('DD MMM Y') }}</td>
            </tr>
        @endforeach
    </x-slot:tbody-rows>
</x-dashboard.table.main-template>
