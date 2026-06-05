@props([
    'cor' => 'terra',
    'tamanho' => 'sm',
])

@php
$cores = match($cor) {
    'emerald', 'sage' => 'bg-sage-50 text-sage-500',
    'amber', 'honey' => 'bg-honey-50 text-honey-400',
    'rose' => 'bg-terra-50 text-terra-500',
    'slate' => 'bg-cream-200 text-bark-500',
    default => 'bg-terra-50 text-terra-500',
};
$tam = match($tamanho) {
    'md' => 'text-sm px-3 py-1',
    default => 'text-xs px-2.5 py-0.5',
};
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center font-medium rounded-full $cores $tam"]) }}>
    {{ $slot }}
</span>
