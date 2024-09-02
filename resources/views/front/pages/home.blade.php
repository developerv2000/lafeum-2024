@extends('front.layouts.app', [
    'bodyClass' => 'home',
    'includeRightbar' => true,
])

@section('leftbar')
    @include('front.leftbars.home')
@endsection

@section('content')
    <p>Content</p>
@endsection

