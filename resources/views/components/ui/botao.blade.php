@props([
    'variante' => 'primario',
    'tamanho' => 'md',
    'href' => null,
    'tipo' => 'button',
])

@php
$base = 'inline-flex items-center justify-center gap-2 font-semibold rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-cream-100 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed';

$variantes = match($variante) {
    'primario' => 'text-white bg-terra-500 hover:bg-terra-600 focus:ring-terra-400',
    'secundario' => 'text-bark-700 bg-cream-200 hover:bg-cream-300 border border-cream-300 focus:ring-bark-300',
    'fantasma' => 'text-bark-500 hover:text-bark-800 hover:bg-cream-200 focus:ring-bark-300',
    'perigo' => 'text-white bg-red-500/80 hover:bg-red-600 focus:ring-red-400',
    default => 'text-white bg-terra-500 hover:bg-terra-600 focus:ring-terra-400',
};

$tamanhos = match($tamanho) {
    'sm' => 'text-xs px-3.5 py-2',
    'lg' => 'text-base px-7 py-3',
    default => 'text-sm px-5 py-2.5',
};
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "$base $variantes $tamanhos"]) }}>{{ $slot }}</a>
@else
    <button type="{{ $tipo }}" {{ $attributes->merge(['class' => "$base $variantes $tamanhos"]) }}>{{ $slot }}</button>
@endif
