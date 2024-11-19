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

        <th width="260">
            <x-dashboard.tables.partials.th.order-link order-by="title" text="Заголовок" />
        </th>

        <th width="180">
            <x-dashboard.tables.partials.th.order-link order-by="title" text="Канал" />
        </th>

        <th width="160">Категории</th>

        <th width="80">Продолжительность</th>

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
                    <x-dashboard.tables.partials.td.restore :form-action="route('dashboard.videos.restore')" :record-id="$record->id" />
                @endif

                <x-dashboard.tables.partials.td.edit :link="route('dashboard.videos.edit', $record->id)" />

                @unless ($trashedRecords)
                    <x-dashboard.tables.partials.td.view :link="route('videos.show', $record->id)" />
                @endunless

                <x-dashboard.tables.partials.td.delete :form-action="route('dashboard.videos.destroy')" :record-id="$record->id" />

                <td>{{ $record->title }}</td>
                <td>{{ $record->channel->name }}</td>

                <td>
                    @foreach ($record->categories as $category)
                        {{ $category->name }}<br>
                    @endforeach
                </td>

                <td>{{ $record->duration }}</td>

                <td>{{ $record->publish_at->isoFormat('DD MMM Y') }}</td>
                <td>{{ $record->created_at->isoFormat('DD MMM Y') }}</td>
                <td>{{ $record->updated_at->isoFormat('DD MMM Y') }}</td>
                <td>{{ $record->id }}</td>
            </tr>
        @endforeach
    </x-slot:tbody-rows>
</x-dashboard.tables.main-template>
