@extends('front.layouts.app', [
    'bodyClass' => 'quotes-show',
    'includeRightbar' => true,
    'title' => $record->share_text,
])

@section('meta-tags')
    <meta name="description" content="{{ $record->share_text }}">
    <meta property="og:description" content="{{ $record->share_text }}">
    <meta property="og:title" content="{{ $record->author->name }}" />
    <meta property="og:image" content="{{ $record->author->photo_asset_url }}">
    <meta property="og:image:alt" content="{{ $record->author->name }}">
@endsection

@section('content')
    <x-front.cards.quotes :quote="$record" />
@endsection
