@props(['records', 'type' => 'default', 'includePagination' => true])

@php
    $wrapperClass = 'main-table-wrapper thin-scrollbar' . ($records->hasPages() ? '' : ' main-table-wrapper--without-pagination');
@endphp

<div {{ $attributes->merge(['class' => $wrapperClass]) }}>
    <table class="main-table">
        <thead>
            <tr>{{ $theadTitles }}</tr>
        </thead>

        <tbody>{{ $tbodyRows }}</tbody>
    </table>
</div>

@if ($includePagination)
    <div class="pagination-wrapper">
        <x-global.navigate-to-page-number :current-page="$records->currentPage()" :last-page="$records->lastPage()" />
        {{ $records->links('dashboard.layouts.pagination') }}
    </div>
@endif
