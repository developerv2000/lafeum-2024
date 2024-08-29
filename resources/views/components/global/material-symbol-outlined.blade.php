@props(['icon', 'filled' => false])

<span {{ $attributes->merge(['class' => $filled ? 'material-symbols-outlined material-symbols--filled' : 'material-symbols-outlined']) }}>{{ $icon }}</span>
