@props(['title'])

<div {{ $attributes->merge(['class' => 'modal']) }}>
    <div class="modal__overlay" data-click-action="hide-active-modals"></div>

    <div class="modal__inner">
        <div class="modal__box">
            {{-- Header --}}
            <div class="modal__header">
                <p class="modal__title">{{ $title }}</p>

                <x-global.button class="modal__dismiss-button" style="transparent" icon="close" data-click-action="hide-active-modals"></x-global.button>
            </div>

            {{-- Body --}}
            <div class="modal__body thin-scrollbar">{{ $body }}</div>

            {{-- Footer --}}
            <div class="modal__footer">{{ $footer }}</div>
        </div>
    </div>
</div>
