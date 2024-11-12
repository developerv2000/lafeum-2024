@extends('dashboard.layouts.app', [
    'pageName' => 'quotes-edit',
])

@section('content')
    <x-form.inputs.record-field-input
        labelText="Body"
        :model="$record"
        field="body"
        :isRequired="true" />

    <x-form.selects.native.id-based-single-select.record-field-select
        labelText="Author"
        :model="$record"
        field="author_id"
        :options="$authors"
        :isRequired="true" />
@endsection
