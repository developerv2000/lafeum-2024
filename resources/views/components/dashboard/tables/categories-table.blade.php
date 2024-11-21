@props(['model', 'records'])

<x-dashboard.tables.main-template :records="$records">
    {{-- thead titles --}}
    <x-slot:thead-titles>
        <x-dashboard.tables.partials.th.select-all />
        <x-dashboard.tables.partials.th.edit />
        <th width="280">Заголовок</th>
        <th>Описание</th>
        <th width="200">Родитель</th>
        <th width="80">Записей</th>
        <th width="80">ID</th>
    </x-slot:thead-titles>

    {{-- tbody rows --}}
    <x-slot:tbody-rows>
        @foreach ($records as $record)
            <tr>
                <x-dashboard.tables.partials.td.checkbox :value="$record->id" />
                <x-dashboard.tables.partials.td.edit :link="route('dashboard.categories.edit', ['model' => $model, 'record' => $record->id])" />
                <td>{{ $record->name }}</td>
                <td><x-dashboard.tables.partials.td.max-lines-limited-text :text="$record->description" /></td>
                <td>{{ $record->parent?->name }}</td>
                <td>{{ $record->records_count }}</td>
                <td>{{ $record->id }}</td>
            </tr>
        @endforeach
    </x-slot:tbody-rows>
</x-dashboard.tables.main-template>
