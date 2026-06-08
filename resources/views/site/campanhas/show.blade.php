<x-layout.app :titulo="$campanha->titulo . ' — Aurora'" :descricao="$campanha->resumo">

    {{-- Hero: vídeo ou imagem --}}
    <div class="relative bg-night-800 overflow-hidden">
        @php
            $youtubeId = null;
            if ($campanha->video_url) {
                preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $campanha->video_url, $m);
                $youtubeId = $m[1] ?? null;
            }
        @endphp

        @if($youtubeId)
            <div class="aspect-video max-h-[60vh] w-full">
                <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}?rel=0&modestbranding=1"
                        class="w-full h-full" frameborder="0" allow="encrypted-media" allowfullscreen></iframe>
            </div>
        @elseif($campanha->imagemUrl())
            <div class="aspect-[21/9] max-h-[50vh] w-full relative">
                <img src="{{ $campanha->imagemUrl() }}" alt="{{ $campanha->titulo }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-night-800/70 to-transparent"></div>
            </div>
        @else
            <div class="h-4"></div>
        @endif
    </div>

    <section class="max-w-5xl mx-auto px-6 pt-8 pb-24">
        <a href="{{ route('campanhas.index') }}" class="inline-flex items-center gap-1.5 text-sm text-bark-400 hover:text-bark-600 transition-colors mb-6">
            &larr; Voltar para campanhas
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            {{-- Conteúdo --}}
            <div class="lg:col-span-2 space-y-10">
                <div>
                    <a href="{{ route('instituicoes.show', $campanha->instituicao->slug) }}"
                       class="inline-flex items-center gap-1.5 text-xs font-medium text-terra-500 hover:text-terra-600 mb-2">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $campanha->instituicao->nome }}
                    </a>
                    <h1 class="font-serif text-3xl lg:text-4xl font-bold text-night-800 leading-tight">{{ $campanha->titulo }}</h1>
                    <p class="text-lg text-bark-400 mt-3">{{ $campanha->resumo }}</p>
                </div>

                <div class="text-bark-600 leading-relaxed text-[16px] space-y-4 font-light">
                    {!! nl2br(e($campanha->descricao)) !!}
                </div>

                {{-- Atualizações --}}
                @if($campanha->atualizacoes->isNotEmpty())
                    <div class="border-t border-cream-200 pt-8">
                        <h2 class="font-serif text-xl font-bold text-night-800 mb-5">Atualizações da campanha</h2>
                        <div class="space-y-6">
                            @foreach($campanha->atualizacoes as $att)
                                <div class="relative pl-6 border-l-2 border-cream-300">
                                    <div class="absolute left-[-5px] top-1.5 w-2 h-2 rounded-full bg-terra-500"></div>
                                    <p class="text-xs text-bark-300 mb-1">{{ $att->created_at->format('d/m/Y') }} · {{ $att->created_at->diffForHumans() }}</p>
                                    <h3 class="font-serif font-bold text-night-800">{{ $att->titulo }}</h3>
                                    @if($att->imagem)
                                        <img src="{{ \Illuminate\Support\Str::startsWith($att->imagem, ['http://','https://']) ? $att->imagem : Storage::url($att->imagem) }}"
                                             alt="{{ $att->titulo }}" class="rounded-xl mt-3 mb-2 max-h-72 w-full object-cover">
                                    @endif
                                    <p class="text-sm text-bark-500 mt-1 leading-relaxed">{{ $att->descricao }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-warm border border-cream-200 p-6 lg:sticky lg:top-20">
                    <x-ui.barra-progresso
                        :percentual="$campanha->percentualArrecadado()"
                        :meta="$campanha->meta"
                        :arrecadado="$campanha->valor_arrecadado"
                        tamanho="lg" />

                    <div class="grid grid-cols-2 gap-3 mt-5 mb-5">
                        <div class="text-center bg-cream-100 rounded-xl py-3">
                            <p class="text-lg font-bold text-night-800">{{ $campanha->totalDoadores() }}</p>
                            <p class="text-xs text-bark-400">apoiadores</p>
                        </div>
                        <div class="text-center bg-cream-100 rounded-xl py-3">
                            <p class="text-lg font-bold text-night-800">{{ number_format($campanha->percentualArrecadado(), 0) }}%</p>
                            <p class="text-xs text-bark-400">da meta</p>
                        </div>
                    </div>

                    @if($campanha->aceitaDoacoes())
                        <a href="{{ route('doacao.create', $campanha->slug) }}"
                           class="block w-full py-3.5 text-sm font-semibold text-white bg-rosa-500 hover:bg-rosa-600 rounded-xl transition-colors text-center">
                            Doar agora
                        </a>
                        <p class="text-center text-xs text-bark-300 mt-3 flex items-center justify-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            Pagamento seguro via PIX
                        </p>
                    @else
                        <div class="w-full py-3.5 text-sm font-semibold text-bark-400 bg-cream-200 rounded-xl text-center">
                            Campanha encerrada
                        </div>
                    @endif

                    <button type="button"
                            x-data="{ copiado: false }"
                            @click="navigator.clipboard.writeText(window.location.href); copiado = true; setTimeout(() => copiado = false, 2000)"
                            class="w-full mt-3 py-2.5 text-sm font-medium text-bark-500 hover:text-bark-700 border border-cream-300 rounded-xl transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                        <span x-show="!copiado">Compartilhar campanha</span>
                        <span x-show="copiado" x-cloak>Link copiado!</span>
                    </button>
                </div>

                {{-- Apoiadores --}}
                @if($campanha->doacoes->isNotEmpty())
                    <div class="bg-white rounded-2xl shadow-warm border border-cream-200 p-6">
                        <p class="text-xs text-bark-300 uppercase tracking-wider font-semibold mb-4">Apoiadores recentes</p>
                        <x-instituicao.mural-apoiadores :doacoes="$campanha->doacoes" />
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-layout.app>
