@extends('front.layouts.app', [
    'bodyClass' => 'quotes-show',
    'includeRightbar' => true,
])

@section('content')
    <x-front.cards.quotes :quote="$record" />
@endsection
