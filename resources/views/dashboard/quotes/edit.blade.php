@extends('dashboard.layouts.app', [
    'pageName' => 'quotes-edit',
    'mainAutoOverflowed' => false,
])

@section('content')
    <x-form.inputs.record-field-input
        labelText="Body"
        :model="$record"
        field="body"
        :isRequired="true" />

    <x-form.selects.selectize.id-based-single-select.record-field-select
        labelText="Author"
        :model="$record"
        field="author_id"
        :options="$authors"
        :isRequired="true" />

    <x-form.selects.selectize.id-based-multiple-select.record-relation-select
        labelText="Categories"
        :model="$record"
        inputName="categories[]"
        :options="$categories"
        :isRequired="true" />
@endsection
