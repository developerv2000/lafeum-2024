@props(['categories', 'linkRouteName'])

<div class="default-card__categories">
    @foreach ($categories as $category)
        <a class="default-card__categories-link" href="{{ route($linkRouteName, $category->slug) }}" target="_blank">{{ $category->name }}</a>
    @endforeach
</div>
