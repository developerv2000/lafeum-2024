@extends('front.layouts.app', [
    'bodyClass' => 'terms-show',
    'includeRightbar' => true,
    'title' => $record->share_text,
])

@section('meta-tags')
    <meta name="description" content="{{ $record->share_text }}">
    <meta property="og:description" content="{{ $record->share_text }}">
    <meta property="og:title" content="{{ $record->type->name }}" />
    <meta property="og:image" content="{{ asset('img/main/share-logo.png') }}">
    <meta property="og:image:alt" content="ЛАФЕЮМ logo">
@endsection

@section('content')
    <script>
        var subterms = {{ Illuminate\Support\Js::from($subtermsArray) }};
    </script>

    <x-front.cards.terms :term="$record" />
@endsection
