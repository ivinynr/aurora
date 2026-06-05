@props(['etapaAtual' => 1])

@php
$etapas = [
    ['numero' => 1, 'label' => 'Valor'],
    ['numero' => 2, 'label' => 'Pagamento'],
    ['numero' => 3, 'label' => 'Confirmação'],
];
@endphp

<div class="flex items-center justify-center gap-0 mb-10">
    @foreach($etapas as $i => $etapa)
        @php
            $ativa = $etapa['numero'] === $etapaAtual;
            $completa = $etapa['numero'] < $etapaAtual;
        @endphp

        <div class="flex flex-col items-center">
            <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-semibold transition-colors
                {{ $completa ? 'bg-night-800 text-white' : ($ativa ? 'bg-night-800 text-white' : 'bg-cream-200 text-bark-400') }}">
                @if($completa)
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                @else
                    {{ $etapa['numero'] }}
                @endif
            </div>
            <span class="text-xs mt-1.5 font-medium {{ $ativa || $completa ? 'text-bark-700' : 'text-bark-300' }}">
                {{ $etapa['label'] }}
            </span>
        </div>

        @if($i < count($etapas) - 1)
            <div class="w-16 sm:w-24 h-0.5 mx-2 mb-5 {{ $etapas[$i + 1]['numero'] <= $etapaAtual ? 'bg-night-800' : 'bg-cream-200' }}"></div>
        @endif
    @endforeach
</div>
