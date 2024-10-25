@props(['records', 'type' => 'default', 'includePaginations' => true])

@php
    $wrapperClass = 'main-table-wrapper thin-scrollbar' . ($records->hasPages() ? '' : 'main-table-wrapper--without-pagination');
@endphp

<div {{ $attributes->merge(['class' => $wrapperClass]) }}>
    <table class="main-table">
        <thead>
            <tr>{{ $theadTitles }}</tr>
        </thead>

        <tbody>{{ $tbodyRows }}</tbody>
    </table>
</div>

@if ($includePaginations)
    <div class="pagination-wrapper">
        <x-global.redirect-to-page-form :current-page="$records->currentPage()" :last-page="$records->lastPage()" />
        {{ $records->links('dashboard.layouts.pagination') }}
    </div>
@endif
