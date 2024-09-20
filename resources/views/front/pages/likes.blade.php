@extends('front.layouts.app', [
    'bodyClass' => 'likes-index',
    'includeRightbar' => false,
])

@section('leftbar')
    @include('front.leftbars.account')
@endsection

@section('content')
    <h1 class="likes-index__title main-title">То что мне понравилось</h1>

    <x-front.lists.mixed :records="$records" relation-name="likeable" model-type-column="likeable_type" :subterms-array="$subtermsArray" />
@endsection
