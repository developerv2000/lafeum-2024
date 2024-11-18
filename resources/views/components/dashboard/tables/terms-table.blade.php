@props(['records', 'trashedRecords' => false])

<x-dashboard.tables.main-template :records="$records">
    {{-- thead titles --}}
    <x-slot:thead-titles>
        <x-dashboard.tables.partials.th.select-all />

        @if ($trashedRecords)
            <x-dashboard.tables.partials.th.deleted-at />
            <x-dashboard.tables.partials.th.restore />
        @endif

        <x-dashboard.tables.partials.th.edit />

        @unless ($trashedRecords)
            <x-dashboard.tables.partials.th.view />
        @endunless

        <x-dashboard.tables.partials.th.delete />

        <th width="160">
            <x-dashboard.tables.partials.th.order-link order-by="name" text="Заголовок" />
        </th>

        <th width="320">Термин</th>

        <th width="150">
            <x-dashboard.tables.partials.th.order-link order-by="term_type_id" text="Тип" />
        </th>

        <th width="200">Категория</th>
        <th width="200">Область знаний</th>

        <th width="150">
            <x-dashboard.tables.partials.th.order-link order-by="show_in_vocabulary" text="Словарь" />
        </th>

        <th width="150">
            <x-dashboard.tables.partials.th.order-link order-by="publish_at" text="Дата публикации" />
        </th>

        <th width="130">
            <x-dashboard.tables.partials.th.order-link order-by="created_at" text="Дата создания" />
        </th>

        <th width="150">
            <x-dashboard.tables.partials.th.order-link order-by="updated_at" text="Дата обновления" />
        </th>

        <th width="80">
            <x-dashboard.tables.partials.th.order-link order-by="id" text="ID" />
        </th>
    </x-slot:thead-titles>

    {{-- tbody rows --}}
    <x-slot:tbody-rows>
        @foreach ($records as $record)
            <tr>
                <x-dashboard.tables.partials.td.checkbox :value="$record->id" />

                @if ($trashedRecords)
                    <td>{{ $record->deleted_at->isoFormat('DD MMM Y') }}</td>
                    <x-dashboard.tables.partials.td.restore :form-action="route('dashboard.terms.restore')" :record-id="$record->id" />
                @endif

                <x-dashboard.tables.partials.td.edit :link="route('dashboard.terms.edit', $record->id)" />

                @unless ($trashedRecords)
                    <x-dashboard.tables.partials.td.view :link="route('terms.show', $record->id)" />
                @endunless

                <x-dashboard.tables.partials.td.delete :form-action="route('dashboard.terms.destroy')" :record-id="$record->id" />

                <td>{{ $record->name }}</td>
                <td><x-dashboard.tables.partials.td.max-lines-limited-text :text="$record->body" /></td>
                <td>{{ $record->type->name }}</td>

                <td>
                    @foreach ($record->categories as $category)
                        {{ $category->name }}<br>
                    @endforeach
                </td>

                <td>
                    @foreach ($record->knowledges as $knowledge)
                        {{ $knowledge->name }}<br>
                    @endforeach
                </td>

                <td>{{ $record->show_in_vocabulary ? 'Да' : 'Нет' }}</td>

                <td>{{ $record->publish_at->isoFormat('DD MMM Y') }}</td>
                <td>{{ $record->created_at->isoFormat('DD MMM Y') }}</td>
                <td>{{ $record->updated_at->isoFormat('DD MMM Y') }}</td>
                <td>{{ $record->id }}</td>
            </tr>
        @endforeach
    </x-slot:tbody-rows>
</x-dashboard.tables.main-template>
