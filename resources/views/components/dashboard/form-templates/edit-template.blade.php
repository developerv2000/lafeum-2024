@props(['action', 'id' => 'edit-form', 'method' => 'PATCH'])

<form
    {{ $attributes->merge(['class' => 'form edit-form']) }}
    action="{{ $action }}"
    id="{{ $id }}"
    method="POST"
    enctype="multipart/form-data"
    data-on-submit="show-spinner">

    @csrf
    @method($method)
    <input type="hidden" name="previous_url" value="{{ old('previous_url', url()->previous()) }}">

    {{ $slot }}

    <div class="form__buttons-wrapper">
        <x-global.button class="form__submit" type="submit" icon="done_all">Сохранить</x-global.button>
    </div>
</form>
