@props([
    'title',
    'subtitle' => null,
    'icon' => null,
    'badge' => null,
])

<div {{ $attributes->class(['page-shell-header']) }}>
    <div class="page-shell-main">
        @if($icon)
        <div class="page-shell-icon" aria-hidden="true">
            <i class="{{ $icon }}"></i>
        </div>
        @endif

        <div class="page-shell-copy">
            @if($badge)
            <span class="page-shell-badge">{{ $badge }}</span>
            @endif
            <h1 class="page-shell-title">{{ $title }}</h1>
            @if($subtitle)
            <p class="page-shell-subtitle">{{ $subtitle }}</p>
            @endif
        </div>
    </div>

    @isset($actions)
    <div class="page-shell-actions">
        {{ $actions }}
    </div>
    @endisset
</div>
