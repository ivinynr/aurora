@props([
    'href' => null,
    'hover' => true,
    'padding' => 'md',
])

@php
$pad = match($padding) {
    'none' => '',
    'sm' => 'p-4',
    'lg' => 'p-8',
    default => 'p-6',
};

$classes = "bg-white rounded-xl shadow-warm border border-cream-200 overflow-hidden $pad";
if ($hover) $classes .= ' card-lift';
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "$classes block"]) }}>{{ $slot }}</a>
@else
    <div {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</div>
@endif
