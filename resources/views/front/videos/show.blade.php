@extends('front.layouts.app', [
    'bodyClass' => 'videos-show',
    'includeRightbar' => true,
])

@section('content')
    <x-front.cards.videos :video="$record" />
@endsection
