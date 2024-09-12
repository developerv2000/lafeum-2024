@extends('front.layouts.app', [
    'bodyClass' => 'terms-show',
    'includeRightbar' => true,
])

@section('content')
    <script>
        var subterms = {{ Illuminate\Support\Js::from($subtermsArray) }};
    </script>

    <x-front.cards.terms :term="$record" />
@endsection
