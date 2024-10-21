@props(['records', 'linkRouteName', 'recordsCaptionAttribute'])

<div class="linked-search">
    <select class="linked-selectize" placeholder="Поиск...">
        {{-- Placeholder --}}
        <option></option>

        {{-- Options --}}
        @foreach ($records as $record)
            <option value="{{ route($linkRouteName, $record->id) }}">{{ $record->{$recordsCaptionAttribute} }}</option>
        @endforeach
    </select>
</div>
