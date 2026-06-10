@props(['doacoes'])

<div class="space-y-2">
    @forelse($doacoes->take(10) as $doacao)
        <div class="py-2.5 animate-fade-in" style="animation-delay: {{ $loop->index * 60 }}ms">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-semibold shrink-0
                    {{ $doacao->anonimo ? 'bg-cream-200 text-bark-400' : 'bg-terra-50 text-terra-500' }}">
                    {{ $doacao->anonimo ? '?' : mb_strtoupper(mb_substr($doacao->nome_doador, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <span class="text-sm text-bark-600">{{ $doacao->nomeExibicao() }}</span>
                    <span class="text-xs text-bark-300 ml-1">{{ $doacao->created_at->diffForHumans() }}</span>
                </div>
                <span class="text-sm font-semibold text-bark-700 shrink-0">R$ {{ number_format($doacao->valor, 2, ',', '.') }}</span>
            </div>
            @if($doacao->mensagem)
                <p class="text-xs text-bark-400 mt-1.5 ml-11 italic">"{{ $doacao->mensagem }}"</p>
            @endif
        </div>
    @empty
        <p class="text-sm text-bark-300 text-center py-6">Seja o primeiro a apoiar.</p>
    @endforelse
</div>
