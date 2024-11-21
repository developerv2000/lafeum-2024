@props(['records'])

<x-dashboard.tables.main-template :records="$records">
    {{-- thead titles --}}
    <x-slot:thead-titles>
        <x-dashboard.tables.partials.th.select-all />
        <x-dashboard.tables.partials.th.delete />

        <th width="200">
            <x-dashboard.tables.partials.th.order-link order-by="name" text="Имя" />
        </th>

        <th width="200">
            <x-dashboard.tables.partials.th.order-link order-by="email" text="Почта" />
        </th>

        <th width="220">
            <x-dashboard.tables.partials.th.order-link order-by="theme" text="Тема" />
        </th>

        <th width="300">Текст</th>

        <th width="130">
            <x-dashboard.tables.partials.th.order-link order-by="created_at" text="Дата создания" />
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
                <x-dashboard.tables.partials.td.delete :form-action="route('dashboard.feedbacks.destroy')" :record-id="$record->id" />
                <td>{{ $record->name }}</td>
                <td>{{ $record->email }}</td>
                <td>{{ $record->theme }}</td>
                <td><x-dashboard.tables.partials.td.max-lines-limited-text :text="$record->message" /></td>
                <td>{{ $record->created_at->isoFormat('DD MMM Y') }}</td>
                <td>{{ $record->id }}</td>
            </tr>
        @endforeach
    </x-slot:tbody-rows>
</x-dashboard.tables.main-template>
