@extends('front.layouts.app', [
    'bodyClass' => 'videos-show',
    'includeRightbar' => true,
])

@section('meta-tags')
    <meta name="description" content="{{ $record->title }}">
    <meta property="og:description" content="{{ $record->title }}">
    <meta property="og:title" content="{{ $record->channel->name }}" />
    <meta property="og:image" content="{{ $record->youtube_thumbnail }}">
    <meta property="og:image:alt" content="{{ $record->title }}">
@endsection

@section('content')
    <x-front.cards.videos :video="$record" />
@endsection
