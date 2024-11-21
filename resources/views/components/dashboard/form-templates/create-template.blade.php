@props([
    'action',
    'id' => 'create-form',
    'submitText' => 'Добавить',
    'submitIcon' => 'done_all',
])

<form
    {{ $attributes->merge(['class' => 'form create-form']) }}
    action="{{ $action }}"
    id="{{ $id }}"
    method="POST"
    enctype="multipart/form-data"
    data-on-submit="show-spinner">

    @csrf
    <input type="hidden" name="previous_url" value="{{ old('previous_url', url()->previous()) }}">

    {{ $slot }}

    <div class="form__buttons-wrapper">
        <x-global.button class="form__submit" type="submit" icon="{{ $submitIcon }}">{{ $submitText }}</x-global.button>
    </div>
</form>
