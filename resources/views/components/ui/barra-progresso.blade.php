@props([
    'percentual' => 0,
    'meta' => null,
    'arrecadado' => null,
    'tamanho' => 'md',
])

@php
$altura = match($tamanho) {
    'sm' => 'h-1.5',
    'lg' => 'h-3',
    default => 'h-2',
};
$pct = min(100, max(0, $percentual));
@endphp

<div class="w-full">
    @if($meta !== null && $arrecadado !== null)
        <div class="flex items-baseline justify-between mb-2">
            <span class="text-sm font-semibold text-bark-700">R$ {{ number_format($arrecadado, 2, ',', '.') }}</span>
            @if($meta > 0)
                <span class="text-xs text-bark-400">meta R$ {{ number_format($meta, 2, ',', '.') }}</span>
            @endif
        </div>
    @endif

    <div class="w-full {{ $altura }} bg-cream-200 rounded-full overflow-hidden">
        <div class="h-full rounded-full progress-fill" style="width: {{ $pct }}%"></div>
    </div>

    @if($meta !== null && $meta > 0)
        <p class="mt-1 text-right text-xs text-bark-400">{{ number_format($pct, 0) }}% alcançado</p>
    @endif
</div>
