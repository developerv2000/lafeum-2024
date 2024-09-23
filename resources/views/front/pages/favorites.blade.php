@extends('front.layouts.app', [
    'bodyClass' => 'favorites-index',
    'includeRightbar' => false,
    'noindex' => true,
    'title' => 'Мои избранные',
])

@section('leftbar')
    @include('front.leftbars.account')
@endsection

@section('content')
    <h1 class="favorites-index__title main-title">Мои избранные</h1>

    {{-- Add folder --}}
    <section class="create-folder styled-box">
        <h2 class="create-folder__title secondary-title">Создать новую папку</h2>

        <form class="create-folder__form form" action="{{ route('folders.store') }}" method="POST" data-on-submit="show-spinner">
            @csrf

            <x-form.input.default-input
                label="Имя папки"
                name="name"
                required />

            <x-form.select.native.id-based-single-select.default-select
                label="Родитель"
                name="parent_id"
                :options="$rootFolders"
                placeholder="Без родителя" />

            <x-global.button class="create-folder__form-submit">Сохранить</x-global.button>
        </form>
    </section>

    {{-- Manage folders --}}
    <section class="manage-folders styled-box">
        <h2 class="manage-folder__title secondary-title">Список всех папок и подпапок</h2>

        @if ($rootFolders->count())
            <x-front.lists.manage-folders :root-folders="$rootFolders" />
        @else
            <p>Здесь пусто...</p>
        @endif
    </section>
@endsection
