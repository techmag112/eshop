@props([
    'route' => 'home',
    'title' => ''
])

<div class="text-xxs md:text-xs">
    <a href="{{ route($route) }}" class="text-white hover:text-white/70 font-bold">
        {{ $title }}
    </a>
</div>
