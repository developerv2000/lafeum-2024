@extends('front.layouts.app', [
    'bodyClass' => 'quotes-show',
    'includeRightbar' => true,
])

@section('meta-tags')
    <meta name="description" content="{{ $record->share_text }}">
    <meta property="og:description" content="{{ $record->share_text }}">
    <meta property="og:title" content="{{ $record->author->name }}" />
    <meta property="og:image" content="{{ asset('img/main/share-logo.png') }}">
    <meta property="og:image:alt" content="ЛАФЕЮМ logo">
@endsection

@section('content')
    <x-front.cards.quotes :quote="$record" />
@endsection
