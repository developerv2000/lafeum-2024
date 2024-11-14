{{-- single-select.request-based-select component not used because highlighting is not required for this inpt --}}
<x-form.groups.default-group labelText="Записей на стр">
    <select class="single-selectize" name="pagination_limit">
        {{-- Empty option for placeholder --}}
        <option></option>

        {{-- Loop through the options and generate each option tag --}}
        @foreach ($paginationLimitOptions as $option)
            <option value="{{ $option }}" @selected($option == request()->input('pagination_limit'))>
                {{ $option }}
            </option>
        @endforeach
    </select>

</x-form.groups.default-group>
