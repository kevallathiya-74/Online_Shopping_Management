@props([
    'icon' => 'fas fa-inbox',
    'title' => 'Nothing here yet',
    'description' => null,
])

<div {{ $attributes->class(['empty-state']) }}>
    <div class="empty-icon"><i class="{{ $icon }}"></i></div>
    <h4 class="mb-2 fw-bold">{{ $title }}</h4>
    @if($description)
    <p class="text-muted mb-4">{{ $description }}</p>
    @endif

    @if(trim((string) $slot) !== '')
    <div class="d-flex justify-content-center flex-wrap gap-2">
        {{ $slot }}
    </div>
    @endif
</div>
