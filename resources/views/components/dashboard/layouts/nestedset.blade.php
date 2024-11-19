@props(['records'])

{{-- Requires refactoring --}}
<div class="nested-container styled-box">
    <ol class="nested">
        @foreach ($records as $record)
            <li class="nested__item" id="menuItem_{{ $record->id }}">
                <div class="nested__item-body">
                    <span class="nested__item-toggler material-symbols-outlined">expand_less</span>
                    <span class="nested__item-title">{{ $record->name }}</span>
                    <span class="nested__item-destroy-btn material-symbols-outlined">close</span>
                </div>

                @if (count($record->children))
                    <ol>
                        @foreach ($record->children as $child)
                            <li class="nested__item" id="menuItem_{{ $child->id }}">
                                <div class="nested__item-body">
                                    <span class="nested__item-toggler material-symbols-outlined">expand_less</span>
                                    <span class="nested__item-title">{{ $child->name }}</span>
                                    <span class="nested__item-destroy-btn material-symbols-outlined">close</span>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                @endif
            </li>
        @endforeach
    </ol>
</div>
