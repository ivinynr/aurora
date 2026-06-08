@props(['instituicao'])

<a href="{{ route('instituicoes.show', $instituicao->slug) }}"
   class="group bg-white rounded-xl shadow-warm border border-cream-200 overflow-hidden card-lift block">

    <div class="aspect-[16/10] bg-cream-200 relative overflow-hidden">
        @if($instituicao->logoUrl())
            <img src="{{ $instituicao->logoUrl() }}" alt="{{ $instituicao->nome }}"
                 class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-700">
        @else
            <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-cream-200 to-cream-300">
                <span class="font-serif text-4xl font-bold text-bark-200">{{ mb_substr($instituicao->nome, 0, 1) }}</span>
            </div>
        @endif
    </div>

    <div class="p-5">
        <h3 class="font-serif text-lg font-bold text-bark-800 mb-1 group-hover:text-terra-500 transition-colors">
            {{ $instituicao->nome }}
        </h3>

        @if($instituicao->missao)
            <p class="text-sm text-bark-400 italic mb-3 line-clamp-1">"{{ $instituicao->missao }}"</p>
        @else
            <p class="text-sm text-bark-400 mb-3 line-clamp-2">{{ $instituicao->descricao }}</p>
        @endif

        <div class="mt-4 pt-3 border-t border-cream-200 flex items-center justify-between">
            @if($instituicao->cidade)
                <span class="text-xs text-bark-300">{{ $instituicao->cidade }}, {{ $instituicao->estado }}</span>
            @else
                <span></span>
            @endif
            <span class="text-xs font-medium text-bark-400">
                {{ $instituicao->campanhas_count ?? $instituicao->campanhas->count() }}
                {{ ($instituicao->campanhas_count ?? 0) === 1 ? 'campanha' : 'campanhas' }}
            </span>
        </div>
    </div>
</a>
