@props(['records'])

<x-dashboard.tables.main-template :records="$records">
    {{-- thead titles --}}
    <x-slot:thead-titles>
        <x-dashboard.tables.partials.th.select-all />

        <th width="80">Фото</th>

        <th width="200">
            <x-dashboard.tables.partials.th.order-link order-by="name" text="Имя" />
        </th>

        <th width="140">
            <x-dashboard.tables.partials.th.order-link order-by="email" text="Почта" />
        </th>

        <th width="140">
            <x-dashboard.tables.partials.th.order-link order-by="birthday" text="День рождения" />
        </th>

        <th width="150">
            <x-dashboard.tables.partials.th.order-link order-by="email_verified_at" text="Подтвердил почту" />
        </th>

        <th width="80">
            <x-dashboard.tables.partials.th.order-link order-by="gender_id" text="Пол" />
        </th>

        <th width="140">
            <x-dashboard.tables.partials.th.order-link order-by="country_id" text="Страна" />
        </th>

        <th width="120">
            <x-dashboard.tables.partials.th.order-link order-by="registered_ip_address" text="IP адрес" />
        </th>

        <th width="120">
            <x-dashboard.tables.partials.th.order-link order-by="registered_browser" text="Браузер" />
        </th>

        <th width="120">
            <x-dashboard.tables.partials.th.order-link order-by="registered_device" text="Устройство" />
        </th>

        <th width="140">
            <x-dashboard.tables.partials.th.order-link order-by="registered_country" text="Страна при рег." />
        </th>

        <th width="260">Биография</th>

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

                <td>
                    <img src="{{ $record->photo_asset_url }}">
                </td>

                <td>{{ $record->name }}</td>
                <td>{{ $record->email }}</td>
                <td>{{ $record->birthday?->isoFormat('DD MMM Y') }}</td>
                <td>{{ $record->email_verified_at?->isoFormat('DD MMM Y') }}</td>
                <td>{{ $record->gender?->name }}</td>
                <td>{{ $record->country?->name }}</td>
                <td>{{ $record->registered_ip_address }}</td>
                <td>{{ $record->registered_browser }}</td>
                <td>{{ $record->registered_device }}</td>
                <td>{{ $record->registered_country }}</td>
                <td><x-dashboard.tables.partials.td.max-lines-limited-text :text="$record->biography" /></td>

                <td>{{ $record->created_at->isoFormat('DD MMM Y') }}</td>
                <td>{{ $record->updated_at->isoFormat('DD MMM Y') }}</td>
                <td>{{ $record->id }}</td>
            </tr>
        @endforeach
    </x-slot:tbody-rows>
</x-dashboard.tables.main-template>
