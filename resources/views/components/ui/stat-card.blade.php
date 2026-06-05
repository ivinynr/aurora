@props([
    'titulo' => '',
    'valor' => '',
    'icone' => '',
    'cor' => 'terra',
])

@php
$corBg = match($cor) {
    'sage' => 'bg-sage-50 text-sage-500',
    'honey' => 'bg-honey-50 text-honey-400',
    'rose' => 'bg-terra-50 text-terra-400',
    default => 'bg-terra-50 text-terra-400',
};
@endphp

<div class="bg-white rounded-xl shadow-warm border border-cream-200 p-5">
    <div class="flex items-start justify-between">
        <div>
            <p class="text-xs font-medium text-bark-400 uppercase tracking-wider mb-1">{{ $titulo }}</p>
            <p class="text-2xl font-bold text-bark-800">{{ $valor }}</p>
        </div>
        @if($icone)
        <div class="w-10 h-10 rounded-lg {{ $corBg }} flex items-center justify-center">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icone }}" />
            </svg>
        </div>
        @endif
    </div>
</div>
