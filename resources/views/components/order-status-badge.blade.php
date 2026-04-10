@props(['status'])

@php
    $normalized = strtolower((string) $status);
    $states = [
        'pending' => ['icon' => 'fa-clock', 'label' => 'Pending'],
        'processing' => ['icon' => 'fa-spinner', 'label' => 'Processing'],
        'completed' => ['icon' => 'fa-check-circle', 'label' => 'Completed'],
        'cancelled' => ['icon' => 'fa-times-circle', 'label' => 'Cancelled'],
    ];
    $current = $states[$normalized] ?? ['icon' => 'fa-circle-info', 'label' => ucfirst($normalized ?: 'Unknown')];
@endphp

<span {{ $attributes->class(["badge badge-status-$normalized", 'status-pill']) }}>
    <i class="fas {{ $current['icon'] }} me-1"></i>{{ $current['label'] }}
</span>
