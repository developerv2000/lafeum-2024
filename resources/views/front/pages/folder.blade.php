@extends('front.layouts.app', [
    'bodyClass' => 'folders-show',
    'includeRightbar' => false,
    'noindex' => true,
    'title' => $record->name,
])

@section('leftbar')
    @include('front.leftbars.account')
@endsection

@section('content')
    <h1 class="folders-show__title main-title">Избранные / {{ $record->name }}</h1>

    <x-front.lists.mixed :records="$favorites" relation-name="favoritable" model-type-column="favoritable_type" :subterms-array="$subtermsArray" />
@endsection
