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

        <th width="120">Фото</th>

        <th width="200">
            <x-dashboard.tables.partials.th.order-link order-by="name" text="Имя" />
        </th>

        <th>Биография</th>

        <th width="120">Группа</th>

        <th width="80">Цитат</th>

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
                    <x-dashboard.tables.partials.td.restore :form-action="route('dashboard.authors.restore')" :record-id="$record->id" />
                @endif

                <x-dashboard.tables.partials.td.edit :link="route('dashboard.authors.edit', $record->id)" />

                @unless ($trashedRecords)
                    <x-dashboard.tables.partials.td.view :link="route('authors.show', $record->slug)" />
                @endunless

                <x-dashboard.tables.partials.td.delete :form-action="route('dashboard.authors.destroy')" :record-id="$record->id" />

                <td>
                    <img src="{{ $record->photo_asset_url }}">
                </td>

                <td>{{ $record->name }}</td>
                <td><x-dashboard.tables.partials.td.max-lines-limited-text :text="$record->biography" /></td>
                <td>{{ $record->group->name }}</td>
                <td>{{ $record->quotes_count }}</td>

                <td>{{ $record->created_at->isoFormat('DD MMM Y') }}</td>
                <td>{{ $record->updated_at->isoFormat('DD MMM Y') }}</td>
                <td>{{ $record->id }}</td>
            </tr>
        @endforeach
    </x-slot:tbody-rows>
</x-dashboard.tables.main-template>
