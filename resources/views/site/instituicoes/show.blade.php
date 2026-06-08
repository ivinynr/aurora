<x-layout.app :titulo="$instituicao->nome . ' — Aurora'">

    {{-- Cabeçalho da instituição --}}
    <section class="bg-night-800 relative overflow-hidden">
        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_15%_20%,#3B82F6_0,transparent_45%),radial-gradient(circle_at_85%_0,#0D9488_0,transparent_40%)]"></div>
        <div class="relative max-w-4xl mx-auto px-6 py-14">
            <div class="flex items-center gap-5">
                <div class="w-20 h-20 rounded-2xl bg-white/10 border border-white/15 overflow-hidden shrink-0 flex items-center justify-center">
                    @if($instituicao->logoUrl())
                        <img src="{{ $instituicao->logoUrl() }}" alt="{{ $instituicao->nome }}" class="w-full h-full object-cover">
                    @else
                        <span class="font-serif text-3xl font-bold text-white">{{ mb_substr($instituicao->nome, 0, 1) }}</span>
                    @endif
                </div>
                <div>
                    <h1 class="font-serif text-2xl lg:text-4xl font-bold text-white leading-tight">{{ $instituicao->nome }}</h1>
                    @if($instituicao->cidade)
                        <p class="text-sm text-cream-200/80 mt-1">{{ $instituicao->cidade }}, {{ $instituicao->estado }}</p>
                    @endif
                </div>
            </div>
            @if($instituicao->missao)
                <p class="text-lg text-cream-200/90 italic font-serif mt-6 max-w-2xl">"{{ $instituicao->missao }}"</p>
            @endif
        </div>
    </section>

    <section class="max-w-4xl mx-auto px-6 pt-10 pb-24">
        <a href="{{ route('instituicoes.index') }}" class="inline-flex items-center gap-1.5 text-sm text-bark-400 hover:text-bark-600 transition-colors mb-8">
            &larr; Todas as instituições
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <div class="lg:col-span-2 space-y-8">
                <div>
                    <h2 class="font-serif text-xl font-bold text-night-800 mb-3">Sobre a instituição</h2>
                    <div class="text-bark-600 leading-relaxed text-[15px] space-y-4 font-light">
                        {!! nl2br(e($instituicao->descricao)) !!}
                    </div>
                </div>

                {{-- Campanhas da instituição --}}
                <div class="border-t border-cream-200 pt-8">
                    <h2 class="font-serif text-xl font-bold text-night-800 mb-5">Campanhas</h2>
                    @if($instituicao->campanhas->isNotEmpty())
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            @foreach($instituicao->campanhas as $campanha)
                                <x-campanha.card :campanha="$campanha" />
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-bark-400">Esta instituição ainda não tem campanhas ativas.</p>
                    @endif
                </div>
            </div>

            {{-- Contato --}}
            <div class="space-y-6">
                @if($instituicao->telefone || $instituicao->email || $instituicao->instagram || $instituicao->website)
                    <div class="bg-white rounded-2xl shadow-warm border border-cream-200 p-6">
                        <p class="text-xs text-bark-300 uppercase tracking-wider font-semibold mb-4">Contato</p>
                        <div class="space-y-2.5 text-sm text-bark-600">
                            @if($instituicao->telefone)<p>📞 {{ $instituicao->telefone }}</p>@endif
                            @if($instituicao->email)<p class="break-all">✉️ {{ $instituicao->email }}</p>@endif
                            @if($instituicao->instagram)<p>📷 {{ $instituicao->instagram }}</p>@endif
                            @if($instituicao->website)<p class="break-all">🌐 {{ $instituicao->website }}</p>@endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-layout.app>
