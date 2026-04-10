@props(['method'])

@php
    $normalized = strtolower((string) $method);
    $isOnline = $normalized === 'online';
@endphp

<span {{ $attributes->class(['badge payment-badge', $isOnline ? 'payment-badge-online' : 'payment-badge-offline']) }}>
    <i class="fas {{ $isOnline ? 'fa-credit-card' : 'fa-money-bill-wave' }} me-1"></i>
    {{ $isOnline ? 'Online Payment' : 'Cash on Delivery' }}
</span>
