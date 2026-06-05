@props(['tipo' => 'info'])

@php
$estilos = match($tipo) {
    'sucesso' => 'bg-sage-50 border-sage-200 text-sage-500',
    'erro' => 'bg-terra-50 border-terra-200 text-terra-600',
    'aviso' => 'bg-honey-50 border-honey-200 text-honey-400',
    default => 'bg-cream-200 border-cream-300 text-bark-600',
};
@endphp

<div {{ $attributes->merge(['class' => "flex items-start gap-3 p-4 rounded-xl border text-sm $estilos"]) }}>
    <div class="font-medium">{{ $slot }}</div>
</div>
